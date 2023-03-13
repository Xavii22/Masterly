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

        return view('pages.home', compact('products', 'query'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Check if the query is empty
        if (empty($query)) {
            return redirect('/home');
        }

        // Check if the current URL is the search URL
        if (url()->current() != route('search')) {
            return redirect('/home?query=' . urlencode($query));
        }

        // Perform the search and display the results
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(40);
        return view('pages.home', compact('products', 'query'));
    }
}
