<?php

namespace App\Livewire\Customer\Auth;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Signup extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    #[Layout('components.layouts.base'), Title('Customer Sign Up')]
    public function render()
    {
        return view('livewire.customer.auth.signup');
    }

    public function signup()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password, // Will be hashed by model cast
            'is_active' => 1,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }
}
