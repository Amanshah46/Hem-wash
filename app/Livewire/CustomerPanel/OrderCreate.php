<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\ServiceDetail;
use App\Models\Addon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderAddonDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class OrderCreate extends Component
{
    public $services = [];
    public $addons = [];
    
    // Selection state
    public $selected_service_id;
    public $selected_service;
    public $service_types = [];
    public $selected_type_id;
    public $item_qty = 1;
    public $item_color = '#000000';

    // Cart items
    public $selservices = []; // index => ['service' => id, 'service_type' => id]
    public $selling_price = []; // index => price
    public $quantity = []; // index => qty
    public $colors = []; // index => hex
    public $inputi = 0;

    // Addons state
    public $selected_addons = []; // addon_id => boolean

    // Order totals and info
    public $sub_total = 0;
    public $addon_total = 0;
    public $tax_percent = 0;
    public $tax = 0;
    public $taxable = 0;
    public $total = 0;
    public $discount = 0;
    
    public $delivery_date;
    public $notes;
    public $order_id;

    #[Layout('components.layouts.customer'), Title('New Order')]
    public function render()
    {
        return view('livewire.customer-panel.order-create');
    }

    public function mount()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $this->services = Service::where('is_active', 1)->latest()->get();
        $this->addons = Addon::where('is_active', 1)->latest()->get();
        $this->delivery_date = Carbon::tomorrow()->toDateString();
        $this->tax_percent = getTaxPercentage();
        $this->generateOrderID();
    }

    public function generateOrderID()
    {
        $code_prefix = 'ORD-';
        $ordernumber = Order::Orderby('id', 'desc')->first();
        if ($ordernumber && $ordernumber->order_number != "") {
            $code = explode("-", $ordernumber->order_number);
            $new_code = (int)$code[1] + 1;
            $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
            $this->order_id = $code_prefix . $new_code;
        } else {
            $this->order_id = $code_prefix . '0001';
        }
    }

    public function selectService($serviceId)
    {
        $this->selected_service_id = $serviceId;
        $this->selected_service = Service::find($serviceId);
        $this->service_types = [];
        $this->selected_type_id = null;

        if ($this->selected_service) {
            $details = ServiceDetail::where('service_id', $serviceId)->get();
            foreach ($details as $detail) {
                $type = ServiceType::find($detail->service_type_id);
                if ($type) {
                    $this->service_types[] = [
                        'id' => $type->id,
                        'name' => $type->service_type_name,
                        'price' => $detail->service_price
                    ];
                }
            }
            if (count($this->service_types) > 0) {
                $this->selected_type_id = $this->service_types[0]['id'];
            }
        }
    }

    public function addItem()
    {
        if (!$this->selected_service_id || !$this->selected_type_id) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Please select a service and service type.']);
            return;
        }

        $detail = ServiceDetail::where('service_id', $this->selected_service_id)
            ->where('service_type_id', $this->selected_type_id)
            ->first();

        if (!$detail) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Price details not found.']);
            return;
        }

        $this->inputi++;
        $this->selservices[$this->inputi] = [
            'service' => $this->selected_service_id,
            'service_type' => $this->selected_type_id
        ];
        $this->selling_price[$this->inputi] = $detail->service_price;
        $this->quantity[$this->inputi] = $this->item_qty;
        $this->colors[$this->inputi] = $this->item_color;

        // Reset inputs
        $this->item_qty = 1;
        $this->item_color = '#000000';
        $this->selected_service_id = null;
        $this->selected_service = null;
        $this->service_types = [];
        $this->selected_type_id = null;

        $this->calculateTotal();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Item added to order cart!']);
    }

    public function removeItem($index)
    {
        unset($this->selservices[$index]);
        unset($this->selling_price[$index]);
        unset($this->quantity[$index]);
        unset($this->colors[$index]);
        $this->calculateTotal();
    }

    public function increaseQty($index)
    {
        if (isset($this->quantity[$index])) {
            $this->quantity[$index]++;
            $this->calculateTotal();
        }
    }

    public function decreaseQty($index)
    {
        if (isset($this->quantity[$index]) && $this->quantity[$index] > 1) {
            $this->quantity[$index]--;
            $this->calculateTotal();
        }
    }

    public function toggleAddon($addonId)
    {
        $this->selected_addons[$addonId] = !($this->selected_addons[$addonId] ?? false);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->sub_total = 0;
        $this->addon_total = 0;
        $this->total = 0;
        $this->tax = 0;
        $this->taxable = 0;
        
        $tax_type = getTaxType();
        $this->tax_percent = getTaxPercentage();

        foreach ($this->selling_price as $key => $value) {
            if (!isset($this->quantity[$key])) continue;
            
            $item_total = $value * $this->quantity[$key];
            if ($tax_type == 2) {
                // Inclusive Tax
                $item_taxable = $item_total * (100 / (100 + $this->tax_percent));
                $item_tax = $item_total - $item_taxable;
                $this->taxable += $item_total;
                $this->sub_total += $item_taxable;
                $this->tax += $item_tax;
            } else {
                // Exclusive Tax
                $item_tax = $item_total * ($this->tax_percent / 100);
                $this->taxable += $item_total;
                $this->sub_total += $item_total;
                $this->tax += $item_tax;
            }
        }

        if ($this->selected_addons) {
            foreach ($this->selected_addons as $key => $value) {
                if ($value === true) {
                    $addon = Addon::find($key);
                    if ($addon) {
                        if ($tax_type == 2) {
                            $addon_taxable = $addon->addon_price * (100 / (100 + $this->tax_percent));
                            $addon_tax = $addon->addon_price - $addon_taxable;
                            $this->taxable += $addon->addon_price;
                            $this->addon_total += $addon_taxable;
                            $this->tax += $addon_tax;
                        } else {
                            $addon_tax = $addon->addon_price * ($this->tax_percent / 100);
                            $this->taxable += $addon->addon_price;
                            $this->addon_total += $addon->addon_price;
                            $this->tax += $addon_tax;
                        }
                    }
                }
            }
        }

        $this->total = ($this->sub_total + $this->addon_total + $this->tax) - $this->discount;
        $this->total = round($this->total, 3, PHP_ROUND_HALF_UP);
    }

    public function submitOrder()
    {
        if (count($this->selservices) === 0) {
            $this->dispatch('alert', ['type' => 'error', 'message' => 'Please add at least one item to your order.']);
            return;
        }

        $customer = Auth::guard('customer')->user();
        $this->generateOrderID();

        $order = Order::create([
            'order_number' => $this->order_id,
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'phone_number' => $customer->phone,
            'order_date' => Carbon::now()->toDateTimeString(),
            'delivery_date' => Carbon::parse($this->delivery_date)->toDateTimeString(),
            'sub_total' => $this->sub_total,
            'addon_total' => $this->addon_total,
            'discount' => $this->discount,
            'tax_percentage' => $this->tax_percent,
            'tax_amount' => $this->tax,
            'tax_type' => getTaxType(),
            'taxable_amount' => $this->taxable,
            'total' => $this->total,
            'note' => $this->notes,
            'status' => 0, // Pending
            'order_type' => 2, // Online Order
            'created_by' => null, // Placed by customer
            'financial_year_id' => getFinancialYearId()
        ]);

        foreach ($this->selservices as $key => $val) {
            $service = Service::find($val['service']);
            $type = ServiceType::find($val['service_type']);

            OrderDetail::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'service_name' => $type->service_type_name,
                'service_quantity' => $this->quantity[$key],
                'service_detail_total' => $this->selling_price[$key] * $this->quantity[$key],
                'service_price' => $this->selling_price[$key],
                'color_code' => $this->colors[$key],
            ]);
        }

        foreach ($this->selected_addons as $addonId => $selected) {
            if ($selected === true) {
                $addon = Addon::find($addonId);
                if ($addon) {
                    OrderAddonDetail::create([
                        'order_id' => $order->id,
                        'addon_id' => $addon->id,
                        'addon_name' => $addon->addon_name,
                        'addon_price' => $addon->addon_price,
                    ]);
                }
            }
        }

        // Send SMS confirmation
        sendOrderCreateSMS($order->id, $customer->id);

        session()->flash('success_order', 'Order #' . $order->order_number . ' placed successfully!');
        return redirect()->route('customer.orders');
    }
}
