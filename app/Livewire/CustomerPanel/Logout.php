<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function mount()
    {
        Auth::guard('customer')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('customer.login');
    }
}
