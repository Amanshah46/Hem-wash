<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    public $total_orders = 0;
    public $active_orders = 0;
    public $completed_orders = 0;
    public $invoice_amount = 0;
    public $payment = 0;
    public $balance = 0;
    public $recent_orders = [];

    #[Layout('components.layouts.customer'), Title('Dashboard')]
    public function render()
    {
        return view('livewire.customer-panel.dashboard');
    }

    public function mount()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $customerId = $customer->id;

        $this->total_orders = Order::where('customer_id', $customerId)->count();
        $this->active_orders = Order::where('customer_id', $customerId)->whereIn('status', [0, 1, 2])->count();
        $this->completed_orders = Order::where('customer_id', $customerId)->where('status', 3)->count();
        
        $this->invoice_amount = Order::where('customer_id', $customerId)->sum('total');
        $this->payment = Payment::where('customer_id', $customerId)->sum('received_amount');
        $this->balance = $this->invoice_amount - $this->payment;

        $this->recent_orders = Order::where('customer_id', $customerId)->latest()->limit(5)->get();
    }
}
