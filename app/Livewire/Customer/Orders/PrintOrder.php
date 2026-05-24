<?php

namespace App\Livewire\Customer\Orders;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Customer;
use App\Models\MasterSettings;
use App\Models\Order;
use App\Models\OrderAddonDetail;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;

class PrintOrder extends Component
{
    public $order, $orderdetails, $orderaddons, $balance, $total, $customer, $payments, $sitename, $address, $phone, $paid_amount, $payment_type, $zipcode, $tax_number, $store_email, $lang;

    #[Layout('components.layouts.print-layout')]
    public function render()
    {
        return view('livewire.orders.print-order');
    }

    public function mount($id)
    {
        $this->order = Order::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->firstOrFail();

        $this->customer = Customer::where('id', $this->order->customer_id)->first();
        $this->orderaddons = OrderAddonDetail::where('order_id', $this->order->id)->get();
        $this->orderdetails = OrderDetail::where('order_id', $this->order->id)->get();
        $this->payments = Payment::where('order_id', $this->order->id)->get();
        $settings = new MasterSettings();
        $site = $settings->siteData();

        $this->sitename = $site['default_application_name'] ?? 'Laundry Box';
        $this->phone = $site['default_phone_number'] ?? '';
        $this->address = $site['default_address'] ?? '';
        $this->zipcode = $site['default_zip_code'] ?? '';
        $this->tax_number = $site['store_tax_number'] ?? '';
        $this->store_email = $site['store_email'] ?? '';

        $this->balance = $this->order->total -  Payment::where('order_id', $this->order->id)->sum('received_amount');
        $this->paid_amount = $this->balance;

        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }
}
