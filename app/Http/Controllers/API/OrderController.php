<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer',
        ]);
        $products = $request->products;

        foreach ($products as $product) {
            $order = new Order();
            $order_details = new OrderDetails();

            $order_details->product_name = $product['name'];
            $order_details->product_price = $product['price'];
            $order_details->product_quantity = $product['quantity'];
            $order_details->total_price = $product['price'] * $product['quantity'];
            $order_details->save();

            $order->order_id = $order_details->id;
            $order->user_id = $request->user_id;
            $order->save();
        }

        return response([
            'status' => 'success',
            'message' => 'Sizning buyurtmangiz qabul qilindi',
            'order' => $order
        ], Response::HTTP_CREATED);
    }
}
