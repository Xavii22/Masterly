<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $query = '';
        return view('pages.cart', compact('request', 'query'));
    }

    public function queryProducts(Request $request)
    {
        $products = Product::whereIn('id', $request)->get();
        return response()->json($products);
    }
}
