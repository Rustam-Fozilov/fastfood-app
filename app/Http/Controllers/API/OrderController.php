<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $orders = Order::with(['orderDetails', 'user'])->first();

        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->get();

        if($request->is_admin) {
            return response([
                'status' => 'success',
                'message' => 'Barcha buyurtmalar',
                'orders' => $orders
            ], Response::HTTP_OK);
        } else {
            return response([
                'status' => 'error',
                'message' => 'Siz ro`yxatdan o`tgan emassiz',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
