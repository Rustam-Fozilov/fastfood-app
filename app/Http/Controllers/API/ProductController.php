<?php

namespace App\Http\Controllers\API;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function productsWithPagination(): \Illuminate\Http\JsonResponse
    {
        $products = Product::paginate(20);
        return response()->json($products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = DB::table('products')->orderBy('created_at', 'desc')->get();
        return response()->json($products);
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image_name = $image->hashName();

        Storage::fake('public');
        Storage::disk('public')->put('assets/products/', $image);
        $request->image->move(public_path('assets/products'), $image_name);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_name' => $image_name,
        ]);

        return response([
            'status' => 'success',
            'message' => 'Mahsulot muvaffaqiyatli saqlandi',
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
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
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $image = $request->file('image');
        $image_name2 = $image->hashName();

        Storage::fake('public');
        Storage::disk('public')->put('assets/products/', $image);
        $image->move(public_path('assets/products'), $image_name2);

        $product = Product::find($id);

        File::delete(public_path('assets/products/' . $product->image_name));

        $order_details = OrderDetails::where('product_name', $product->name)->pluck('id');
        if ($order_details->count() > 0) {
            foreach ($order_details as $item) {
                $order_detail = OrderDetails::find($item);
                $order_detail->product_name = $request->name;
                $order_detail->product_price = $request->price;
                $order_detail->save();
            }
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image_name = $image_name2;
        $product->save();

        return response([
            'status' => 'success',
            'message' => 'Mahsulot muvaffaqiyatli yangilandi',
            'product' => $product
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name)
    {
        $order_details = DB::table('order_details')->where('product_name', $name)->pluck('id');

        if($order_details->count() > 0) {
            foreach ($order_details as $item) {
                OrderDetails::where('id', $item)->delete();
                Order::where('order_id', $item)->delete();
            }
        }

        $product = Product::where('name', $name)->first();
        $product->delete();

        File::delete(public_path('assets/products/' . $product->image_name));

        return response([
            'status' => 'success',
            'message' => 'Mahsulot muvaffaqiyatli o`chirildi',
        ], Response::HTTP_OK);
    }
}
