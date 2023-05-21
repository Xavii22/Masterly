<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public static function productNotFound()
    {
        $products = Product::inRandomOrder()->limit(10)->get();
        return view('errors.productNotFound', compact('products'));
    }

    public static function storeNotFound()
    {
        $products = Product::inRandomOrder()->limit(10)->get();
        return view('errors.storeNotFound', compact('products'));
    }

    public function defaultError()
    {
        return view('errors.defaultError');
    }
}
