<?php

namespace App\Livewire\Customer\Orders;

use Livewire\Component;
use App\Models\Addon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceType;
use App\Models\OrderAddonDetail;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class AddOrder extends Component
{
    public $services, $search_query, $order_id, $inputs = [], $selservices = [], $date, $delivery_date;
    public $service_types, $service, $inputi = 0, $prices = [], $selling_price = [], $quantity = [], $selected_type = [], $addons, $selected_addons = [], $colors = [];
    public $clothes, $selected_cloth = [];
    public $total, $sub_total, $addon_total, $tax_percent, $tax, $lang, $taxamount;
    public $taxable;

    #[Layout('components.layouts.customer'), Title('Add Order')]
    public function render()
    {
        return view('livewire.customer.orders.add-order');
    }

    public function mount()
    {
        $this->services = Service::where('is_active', 1)->latest()->get();
        $this->clothes = \App\Models\Cloth::where('is_active', 1)->latest()->get();
        $this->date = Carbon::today()->toDateString();
        $this->addons = Addon::where('is_active', 1)->latest()->get();
        $this->delivery_date = Carbon::today()->addDays(2)->toDateString();
        $this->tax_percent = getTaxPercentage();
        $this->generateOrderID();

        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
        $this->service_types = collect();
        $this->calculateTotal();
    }

    public function updated($name, $value)
    {
        if ($value == '') data_set($this, $name, null);
        if ($name == 'search_query' && $value != '') {
            $this->services = Service::where('service_name', 'like', '%' . $value . '%')->latest()->get();
        } elseif ($name == 'search_query' && $value == '') {
            $this->services = Service::latest()->get();
        }

        if (strpos($name, 'selling_price') !== false || strpos($name, 'prices') !== false || strpos($name, 'quantity') !== false) {
            $this->calculateTotal();
        }
        $this->calculateTotal();
    }

    public function selectService($id)
    {
        $this->selected_type = [];
        $this->service = Service::where('id', $id)->first();
        $this->service_types = collect();
        if ($this->service) {
            $servicedetails = ServiceDetail::where('service_id', $id)->get();
            foreach ($servicedetails as $row) {
                $servicetype = ServiceType::where('id', $row->service_type_id)->first();
                $servicetype['price'] = getFormattedCurrency($row->service_price);
                $this->service_types->push($servicetype->toArray());
            }
        }
        if (count($this->service_types) > 0) {
            $first = $this->service_types->first();
            if ($first) {
                $this->selected_type[$first['id']] = true;
            }
        }
        $this->calculateTotal();
    }

    public function addItem()
    {
        if ($this->service) {
            $anyTicked = false;
            foreach ($this->selected_type as $item) {
                if ($item == true) {
                    $anyTicked = true;
                }
            }
            if (count($this->selected_type) > 0 && $anyTicked) {
                $tax_type = getTaxType();
                foreach ($this->selected_type as $item => $value) {
                    if ($value === true) {
                        $this->add($this->inputi);
                        $this->selservices[$this->inputi]['service'] = $this->service->id;
                        $this->selservices[$this->inputi]['service_type']  = $item;
                        $this->selservices[$this->inputi]['cloth'] = $this->selected_cloth[$item] ?? null;
                        $servicedetail = ServiceDetail::where('service_id', $this->service->id)->where('service_type_id', $item)->first();
                        if ($servicedetail) {
                            if ($tax_type == 2) {
                                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
                                $itemtotallocal =   $servicedetail->service_price  * (100 / (100 + $this->tax_percent ?? 0));
                                $this->prices[$this->inputi] = number_format($itemtotallocal, 2);
                            } else {
                                $this->prices[$this->inputi] =  $servicedetail->service_price;
                                $this->selling_price[$this->inputi] =  $servicedetail->service_price;
                            }
                        }
                    }
                }
                $this->service_types = collect();
                $this->selected_cloth = [];
                $this->selected_type = [];
                $this->dispatch('closemodal');
                $this->calculateTotal();
            } else {
                $this->addError('service_error', 'Select a service type');
                return 0;
            }
        }
    }

    public function add($i)
    {
        $this->inputi = $i + 1;
        $this->inputs[$this->inputi] = 1;
        $this->prices[$this->inputi] = 0;
        $this->quantity[$this->inputi]  = 1;
        $this->colors[$this->inputi]  = '';
    }

    public function increase($key)
    {
        if (isset($this->quantity[$key])) {
            $this->quantity[$key]++;
            $this->calculateTotal();
        }
    }

    public function decrease($key)
    {
        if (isset($this->quantity[$key])) {
            if ($this->quantity[$key] > 1) {
                $this->quantity[$key]--;
            } else {
                $this->removeItem($key);
            }
            $this->calculateTotal();
        }
    }

    public function removeItem($key)
    {
        unset($this->quantity[$key]);
        unset($this->prices[$key]);
        unset($this->selservices[$key]);
        unset($this->selling_price[$key]);
        unset($this->colors[$key]);
        $this->calculateTotal();
    }

    public function generateOrderID()
    {
        $code_prefix = 'ORD-';
        $ordernumber = Order::orderBy('id', 'desc')->lockForUpdate()->first();
        if ($ordernumber && $ordernumber->order_number != "") {
            $code = explode("-", $ordernumber->order_number);
            $new_code = $code[1] + 1;
            $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
            $this->order_id = $code_prefix . $new_code;
        } else {
            $this->order_id = $code_prefix . '0001';
        }
    }

    public function calculateTotal()
    {
        $this->total = 0;
        $this->sub_total = 0;
        $this->tax = 0;
        $this->taxable = 0;
        $this->addon_total = 0;

        $tax_type = getTaxType();
        foreach ($this->selling_price as $key => $value) {
            if ($tax_type == 2) {
                $itemtotallocal = ($value * $this->quantity[$key]) * (100 / (100 + $this->tax_percent ?? 0));
                $this->tax += ($value * $this->quantity[$key]) - $itemtotallocal;
                $this->sub_total += $itemtotallocal;
                $this->taxable += $itemtotallocal;
            } else {
                $itemtotallocal = ($value * $this->quantity[$key]);
                $this->tax += $itemtotallocal * $this->tax_percent / 100;
                $this->sub_total += $itemtotallocal;
                $this->taxable += $itemtotallocal;
            }
        }

        if ($this->selected_addons) {
            foreach ($this->selected_addons as $key => $value) {
                if ($value === true) {
                    $addon = Addon::find($key);
                    if ($addon) {
                        if ($tax_type == 2) {
                            $itemtotallocal = ($addon->addon_price) * (100 / (100 + $this->tax_percent ?? 0));
                            $this->tax += ($addon->addon_price) - $itemtotallocal;
                            $this->addon_total += $itemtotallocal;
                            $this->sub_total += $itemtotallocal;
                            $this->taxable += $itemtotallocal;
                        } else {
                            $itemtotallocal = ($addon->addon_price);
                            $this->tax += $itemtotallocal * $this->tax_percent / 100;
                            $this->addon_total += $itemtotallocal;
                            $this->sub_total += $itemtotallocal;
                            $this->taxable += $itemtotallocal;
                        }
                    }
                }
            }
        }
        $this->total = $this->sub_total + $this->tax;
        $this->total = round($this->total, 2);
    }

    public function save()
    {
        if (count($this->selservices) <= 0) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Your cart is empty']);
            return;
        }

        $customer = Auth::guard('customer')->user();

        \Illuminate\Support\Facades\DB::transaction(function () use ($customer) {
            $this->generateOrderID();
            $order = Order::create([
                'order_number'      => $this->order_id,
                'customer_id'       => $customer->id,
                'customer_name'     => $customer->name,
                'phone_number'      => $customer->phone,
                'order_date'        => Carbon::parse($this->date)->toDateTimeString(),
                'delivery_date'     => Carbon::parse($this->delivery_date)->toDateTimeString(),
                'sub_total'         => $this->sub_total,
                'addon_total'       => $this->addon_total,
                'discount'          => 0,
                'tax_percentage'    => $this->tax_percent,
                'tax_amount'        => $this->tax,
                'tax_type'          => getTaxType(),
                'taxable_amount'    => $this->taxable,
                'total'             => $this->total,
                'status'            => 0,
                'order_type'        => 1,
                'created_by'        => null, // Created by customer
                'financial_year_id' => getFinancialYearId()
            ]);

            foreach ($this->selservices as $key => $value) {
                $service_type = ServiceType::find($value['service_type']);
                OrderDetail::create([
                    'order_id'              => $order->id,
                    'service_id'            => $value['service'],
                    'cloth_id'              => $value['cloth'] ?? null,
                    'service_name'          => $service_type->service_type_name,
                    'service_quantity'      => $this->quantity[$key],
                    'service_detail_total'  => $this->selling_price[$key] * $this->quantity[$key],
                    'service_price'         => $this->selling_price[$key],
                    'color_code'            => $this->colors[$key],
                ]);
            }

            if ($this->selected_addons) {
                foreach ($this->selected_addons as $key => $value) {
                    if ($value === true) {
                        $addon = Addon::find($key);
                        OrderAddonDetail::create([
                            'order_id'    => $order->id,
                            'addon_id'    => $addon->id,
                            'addon_name'  => $addon->addon_name,
                            'addon_price' => $addon->addon_price,
                        ]);
                    }
                }
            }
        });

        $this->dispatch('alert', ['type' => 'success', 'message' => 'Order created successfully!']);
        return redirect()->route('customer.orders');
    }
}
