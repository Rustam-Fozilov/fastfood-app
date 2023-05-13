<?php

namespace Tests\Feature;

use App\Models\Order;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_show_order()
    {
        $response = $this->post('http://localhost:8000/api/orders', [
            'is_admin' => true,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_create_order()
    {
        $file = 'http://localhost:8000/product.test.json';
        $json = json_decode(file_get_contents($file), true);
        $products = [
            $json
        ];


        $response = $this->post('http://localhost:8000/api/confirm_order', [
            "products" => $products,
            "user_id" => 2,
        ]);

        $response->assertStatus(201);
    }

    public function test_can_update_order()
    {
        $order = Order::latest()->first();

        $file = 'http://localhost:8000/product.test.json';
        $json = json_decode(file_get_contents($file), true);
        $products = [
            $json
        ];


        $response = $this->put('http://localhost:8000/api/order/' . $order->id, [
            "products" => $products,
            "user_id" => 2,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_search_order()
    {
        $order = Order::latest()->first();

        $response = $this->post('http://localhost:8000/api/orders/search', [
            "search" => $order->created_at
        ]);

        $response->assertStatus(200);
    }

    public function test_can_download_orders()
    {
        $response = $this->get('http://localhost:8000/api/orders-export');

        $response->assertStatus(200);
    }

    public function test_can_delete_order()
    {
        $order = Order::latest()->first();

        $response = $this->delete('http://localhost:8000/api/orders/' . $order->id);

        $response->assertStatus(200);
    }
}
