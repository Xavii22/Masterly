<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class EditProductController extends Controller
{

    public function editProduct($productId)
    {
        $product = Product::where('id', $productId)->first();
        $subcategories = Category::getAllSpecificCategories('C');
        $tags = Category::getAllSpecificCategories('T');
        return view('pages.editProduct', compact('product', 'productId', 'subcategories', 'tags'));
    }

    public function editDetails(Request $request)
    {
        $product = Product::where('id', $request->route('id'))->first();

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->save();
    }
}
