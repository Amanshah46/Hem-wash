<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class Login extends Component
{
    public $email;
    public $password;

    #[Layout('components.layouts.base'), Title('Customer Login')]
    public function render()
    {
        return view('livewire.customer-panel.login');
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('customer')->attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            return redirect()->intended(route('customer.dashboard'));
        }

        $this->addError('login_error', 'Invalid Email or Password.');
    }

    public function mount()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
    }
}
