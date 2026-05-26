<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_see_login_page()
    {
        $response = $this->get(route('customer.login'));

        $response->assertStatus(200);
        $response->assertSee('Customer Sign In');
    }

    public function test_customer_cannot_access_orders_without_logging_in()
    {
        $response = $this->get(route('customer.orders'));

        $response->assertRedirect(route('customer.login'));
    }

    public function test_customer_can_login()
    {
        $customer = Customer::create([
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'is_active' => 1
        ]);

        $this->assertTrue(auth()->guard('customer')->attempt(['email' => 'test@example.com', 'password' => 'password']));
    }

    public function test_customer_can_signup()
    {
        $response = \Livewire\Livewire::test(\App\Livewire\Customer\Auth\Signup::class)
            ->set('name', 'New Customer')
            ->set('email', 'new@example.com')
            ->set('phone', '0987654321')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('signup');

        $response->assertRedirect(route('customer.dashboard'));

        $this->assertDatabaseHas('customers', [
            'email' => 'new@example.com',
            'name' => 'New Customer'
        ]);
    }
}
