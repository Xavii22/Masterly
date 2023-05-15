<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateProductController extends Controller
{
    public function creator()
    {
        $subcategories = Category::where('type', 'C')->get();
        return view('pages.createProduct', compact('subcategories'));
    }

    public function createProduct(Request $request)
    {
        Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'image' => $request['image'],
            'store_id' => Store::where('user_id', Auth::id())->value('id')
        ]);
        return view('pages.manageStore');
    }


}
