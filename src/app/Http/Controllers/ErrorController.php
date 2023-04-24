<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public static function productNotFound()
    {
        $products = Product::inRandomOrder()->limit(8)->get();
        return view('errors.productNotFound', compact('products'));
    }

    public function storeNotFound()
    {
        return view('errors.storeNotFound');
    }

    public function defaultError()
    {
        return view('errors.defaultError');
    }
}
