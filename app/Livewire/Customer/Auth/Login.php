<?php

namespace App\Livewire\Customer\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\MasterSettings;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class Login extends Component
{
    public $email, $password;

    #[Layout('components.layouts.base'), Title('Customer Login')]
    public function render()
    {
        return view('livewire.customer.auth.login');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('customer')->attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => 1])) {
            return redirect()->route('customer.orders');
        } else {
            $this->addError('login_error', 'Invalid Email/Password or account inactive');
        }
    }

    public function mount()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.orders');
        }
    }
}
