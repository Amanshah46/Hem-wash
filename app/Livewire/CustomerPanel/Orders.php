<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $search_query = '';
    public $status_filter = '';

    protected $paginationTheme = 'bootstrap';

    #[Layout('components.layouts.customer'), Title('My Orders')]
    public function render()
    {
        $customerId = Auth::guard('customer')->id();
        if (!$customerId) {
            return redirect()->route('customer.login');
        }

        $query = Order::where('customer_id', $customerId)->latest();

        if ($this->search_query != '') {
            $query->where('order_number', 'like', '%' . $this->search_query . '%');
        }

        if ($this->status_filter !== '') {
            $query->where('status', $this->status_filter);
        }

        return view('livewire.customer-panel.orders', [
            'orders' => $query->paginate(10)
        ]);
    }

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
}
