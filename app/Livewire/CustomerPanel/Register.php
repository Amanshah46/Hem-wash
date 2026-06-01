<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;


    #[Layout('components.layouts.base'), Title('Customer Registration')]
    public function render()
    {
        return view('livewire.customer-panel.register');
    }

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|unique:customers,phone',
            'password' => 'required|string|min:6',
        ]);

        Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'is_active' => 1,
        ]);

        session()->flash('success_register', 'Registration successful! Please login with your credentials.');
        return redirect()->route('customer.login');
    }

    public function mount()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('customer.dashboard');
        }
    }
}
