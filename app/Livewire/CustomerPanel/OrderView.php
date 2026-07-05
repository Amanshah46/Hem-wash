<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderAddonDetail;
use App\Models\Payment;
use App\Models\MasterSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class OrderView extends Component
{
    public $order;
    public $orderdetails = [];
    public $orderaddons = [];
    public $payments = [];

    public $sitename;
    public $address;
    public $phone;
    public $store_email;
    public $zipcode;
    public $tax_number;

    public $paid_amount = 0;
    public $balance = 0;

    #[Layout('components.layouts.customer'), Title('Track Order')]
    public function render()
    {
        return view('livewire.customer-panel.order-view');
    }

    public function mount($id)
    {
        $customerId = Auth::guard('customer')->id();
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $this->order = Order::where('customer_id', $customerId)->where('id', $id)->firstOrFail();

        $this->orderdetails = OrderDetail::where('order_id', $this->order->id)->get();
        $this->orderaddons = OrderAddonDetail::where('order_id', $this->order->id)->get();
        $this->payments = Payment::where('order_id', $this->order->id)->get();

        $settings = new MasterSettings();
        $site = $settings->siteData();

        $this->sitename = $site['default_application_name'] ?? 'Laundry ';
        $this->phone = $site['default_phone_number'] ?? '123456789';
        $this->address = $site['default_address'] ?? 'Address';
        $this->zipcode = $site['default_zip_code'] ?? 'ZipCode';
        $this->tax_number = $site['store_tax_number'] ?? 'Tax Number';
        $this->store_email = $site['store_email'] ?? 'store@store.com';

        $this->paid_amount = Payment::where('order_id', $this->order->id)->sum('received_amount');
        $this->balance = $this->order->total - $this->paid_amount;
    }
}
