<?php

namespace App\Livewire\Customer\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function mount()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }
}
