<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use GuzzleHttp\Client;
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
        $product = Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'store_id' => Store::where('user_id', Auth::id())->value('id')
        ]);

        $categoryId = Category::where('name', $request->input('subcategory'))->value('id');
        $product->categories()->attach($categoryId);

        $client = new Client([
            'verify' => false,
        ]);

        $main = true;
        foreach ($request->file() as $image) {
            $client->post(env('API_URL') . '/api/store', [
                'json' => [
                    'image' => base64_encode(file_get_contents($image->path())),
                    'main' => $main,
                    'product_id' => $product->id
                ]
            ]);
            $main = false;
        }
        return view('pages.manageStore');
    }
}
