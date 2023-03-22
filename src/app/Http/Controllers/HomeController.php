<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $query = $request->input('query', '');
        $products = Product::paginate(40);
        $sort = '';

        return view('pages.home', compact('products', 'query', 'sort'));
    }

    public function search(Request $request, $sort = 'asc')
    {
        $query = $request->input('query');
        $sort = $request->input('sort', 'asc');

        if (url()->current() != route('search')) {
            return redirect('/home?query=' . urlencode($query));
        }

        $products = Product::where('name', 'like', '%' . $query . '%')->orderBy('name', $sort)->paginate(40);
        return view('pages.home', compact('products', 'query', 'sort'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product', compact('product'));
    }
}
