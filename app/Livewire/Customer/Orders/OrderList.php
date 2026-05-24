<?php

namespace App\Livewire\Customer\Orders;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderList extends Component
{
    public $orders;
    public $search_query;
    public $order_filter, $lang;
    public $nextCursor;
    public $hasMorePages;
    public $paid_filter;

    #[Layout('components.layouts.customer'), Title('My Orders')]
    public function render()
    {
        return view('livewire.customer.orders.order-list');
    }

    public function mount()
    {
        $this->orders = new EloquentCollection();
        $this->loadOrders();
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }

    public function updated($name, $value)
    {
        $this->reloadOrders();
    }

    public function loadOrders()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }
        $myorder = $this->filterdata();
        $this->orders->push(...$myorder->items());
        if ($this->hasMorePages = $myorder->hasMorePages()) {
            $this->nextCursor = $myorder->nextCursor()->encode();
        }
    }

    public function reloadOrders()
    {
        $this->orders = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        $orders = $this->filterdata();
        $this->orders->push(...$orders->items());
        if ($this->hasMorePages = $orders->hasMorePages()) {
            $this->nextCursor = $orders->nextCursor()->encode();
        }
    }

    public function filterdata()
    {
        $query = Order::where('customer_id', Auth::guard('customer')->id())->orderBy('order_number', 'DESC');

        if ($this->search_query) {
            $query->where('order_number', 'like', '%' . $this->search_query . '%');
        }

        if ($this->order_filter) {
            $query->where('status', $this->order_filter);
        }

        return $query->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
    }
}
