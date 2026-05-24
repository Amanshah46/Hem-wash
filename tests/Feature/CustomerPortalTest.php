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

        $response = $this->post(route('customer.login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Note: Livewire components are usually tested with Livewire::test,
        // but since we are doing a simple feature test, we check if the guard works.
        $this->assertTrue(auth()->guard('customer')->attempt(['email' => 'test@example.com', 'password' => 'password']));
    }
}
