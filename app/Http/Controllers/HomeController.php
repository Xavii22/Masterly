<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        return view('pages.home', compact('products'));
    }
}
