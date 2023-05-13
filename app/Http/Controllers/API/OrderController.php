<?php

namespace App\Http\Controllers\API;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function export() {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function ordersWithPagination(Request $request)
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(20);

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->orderBy('orders.created_at', 'desc')
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
            'user_id' => 'required|integer',
        ]);
        $products = $request->products;

        foreach ($products as $product) {
            $order = new Order();
            $order_details = new OrderDetails();

            $order_details->product_name = $product["name"];
            $order_details->product_price = $product["price"];
            $order_details->product_quantity = $product["quantity"];
            $order_details->total_price = $product["price"] * $product["quantity"];
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
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->where('orders.user_id', $id)
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return response([
            'status' => 'success',
            'message' => 'Sizning buyurtmalaringiz',
            'orders' => $orders
        ], Response::HTTP_OK);
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
    public function update($id, Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'user_id' => 'required|integer',
        ]);

        $order = Order::where('order_id', $id)->first();
        $order->user_id = $request->user_id;

        $order_details = OrderDetails::find($order->order_id);
        $product = $request->products;

        $order_details->product_name = $product["name"];
        $order_details->product_price = $product["price"];
        $order_details->product_quantity = $product["quantity"];
        $order_details->total_price = $product["price"] * $product["quantity"];
        $order_details->save();
        $order->save();

        return response([
            'status' => 'success',
            'message' => 'Buyurtma muvaffaqiyatli yangilandi',
            'order' => $order
        ], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $order = Order::where('order_id', $id)->first();
        $order->delete();

        $order_details = OrderDetails::find($id);
        $order_details->delete();

        return response([
            'status' => 'success',
            'message' => 'Buyurtma o`chirildi',
        ], Response::HTTP_OK);
    }

    public function search(Request $request)
    {
        $result = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.id')
            ->select('orders.*', 'users.*', 'order_details.*')
            ->where('users.name', 'like', '%'.$request->search.'%')
            ->orWhere('users.email', 'like', '%'.$request->search.'%')
            ->orWhere('users.id', 'like', '%'.$request->search.'%')
            ->orWhere('order_details.product_name', 'like', '%'.$request->search.'%')
            ->orWhere('orders.created_at', 'like', '%'.$request->search.'%')
            ->orderBy('orders.created_at', 'asc')
            ->get();

        if($result) {
            return response([
                'status' => 'success',
                'message' => 'Buyurtma topildi',
                'result' => $result
            ], Response::HTTP_OK);
        } else {
            return response([
                'status' => 'error',
                'message' => 'Buyurtma topilmadi',
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
