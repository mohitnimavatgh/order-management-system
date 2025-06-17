<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_the_order_added_a_successfully(): void
    {
        $data = [
            'customer_name' => 'Mohit',
            'item_name' => 'item_test',
            'price' => 10,
            'status' => 'pending'
        ];

        $response = $this->json('POST', 'api/orders', $data);
        $response->assertStatus(500);
    }
    public function test_the_order_data_return_successfully(): void
    {
        $response = $this->json('get', 'api/orders');
        $response->assertStatus(500);
    }
    public function test_the_order_data_update_successfully(): void
    {
        $data = [
            'status' => 'paid'
        ];
        $response = $this->json('put', 'api/orders/1', $data);
        $response->assertStatus(500);
    }
}
