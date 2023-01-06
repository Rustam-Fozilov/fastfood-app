<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function products(Request $request)
    {
        $search = $request->input('query');
        $products = Product::where('name', 'like', "%$search%")->get();
        return response()->json($products);
    }
}
