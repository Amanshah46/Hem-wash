<?php

namespace App\Livewire\CustomerPanel;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;

class Profile extends Component
{
    // Profile fields
    public $name;
    public $email;
    public $phone;
    public $address;
    public $tax_number;

    // Password change fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    #[Layout('components.layouts.customer'), Title('My Profile')]
    public function render()
    {
        return view('livewire.customer-panel.profile');
    }

    public function mount()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $customer = Auth::guard('customer')->user();
        $this->name        = $customer->name;
        $this->email       = $customer->email;
        $this->phone       = $customer->phone;
        $this->address     = $customer->address;
        $this->tax_number  = $customer->tax_number;
    }

    /**
     * Update name, email, phone, address, tax_number
     */
    public function updateProfile()
    {
        $customer = Auth::guard('customer')->user();

        $this->validate([
            'name'       => 'required|string|max:255',
            'email'      => ['required', 'email', Rule::unique('customers', 'email')->ignore($customer->id)],
            'phone'      => ['required', 'string', Rule::unique('customers', 'phone')->ignore($customer->id)],
            'address'    => 'nullable|string',
        ]);

        $customer->update([
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'address'    => $this->address,
        ]);

        $this->dispatch('alert', [
            'type'    => 'success',
            'message' => 'Profile updated successfully!',
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword()
    {
        $this->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        $customer = Auth::guard('customer')->user();

        if (!Hash::check($this->current_password, $customer->password)) {
            $this->addError('current_password', 'The current password you entered is incorrect.');
            return;
        }

        $customer->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('alert', [
            'type'    => 'success',
            'message' => 'Password changed successfully!',
        ]);
    }
}
