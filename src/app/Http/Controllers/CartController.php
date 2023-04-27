<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        return view('pages.cart', compact('request'));
    }

    public function queryProducts(Request $request)
    {
        if (Auth::check()) {
            $products = Cart::getCartProducts();

            return response()->json($products);
        }
        $products = Product::whereIn('id', $request)->get();
        return response()->json($products);
    }
}
