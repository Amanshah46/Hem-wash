<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    public $total_orders, $pending_orders, $ready_orders, $recent_orders;

    #[Layout('components.layouts.customer'), Title('Customer Dashboard')]
    public function render()
    {
        return view('livewire.customer.dashboard');
    }

    public function mount()
    {
        $customer_id = Auth::guard('customer')->id();
        $this->total_orders = Order::where('customer_id', $customer_id)->count();
        $this->pending_orders = Order::where('customer_id', $customer_id)->whereIn('status', [0, 1, 2])->count();
        $this->ready_orders = Order::where('customer_id', $customer_id)->where('status', 3)->count();
        $this->recent_orders = Order::where('customer_id', $customer_id)->latest()->take(5)->get();
    }
}
