<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Option;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_paginated_list_of_orders()
    {
        Order::factory(10)->create();

        $response = $this->get('/api/orders');

        $response->assertStatus(200);

        $response->assertJsonStructure(['data']);
    }

    public function test_can_create_an_order()
    {
        $orderData = [
            'user_id' => 1,
            'total_amount' => 100.00,
            'status' => 'pending',
            'items' => [
                [
                    'product_id' => 1,
                    'option_id' => 1,
                    'quantity' => 2,
                ],
            ],
        ];

        Product::factory()->create();
        Option::factory()->create();

        $response = $this->post('/api/orders', $orderData);

        $response->assertStatus(200);

        $response->assertJsonStructure(['data']);
    }

    public function test_can_show_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->get("/api/orders/{$order->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure(['data']);
    }

    public function test_can_update_order_status()
    {
        $order = Order::factory()->create();

        $response = $this->put("/api/orders/{$order->id}/update-status", ['status' => 'shipped']);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'shipped']);
    }

    public function test_can_cancel_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->delete("/api/orders/{$order->id}/cancel");

        $response->assertStatus(200);

        $this->assertDeleted($order);
    }
}

