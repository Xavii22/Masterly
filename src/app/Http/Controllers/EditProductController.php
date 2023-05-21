<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class EditProductController extends Controller
{

    public function createProduct()
    {
    }

    public function editProduct($productId)
    {
        $categoryInstance = new Category();

        $product = Product::where('id', $productId)->first();
        $subcategories = $categoryInstance->getActiveCategoriesOfProduct('C', $productId);

        return view('pages.editProduct', compact('product', 'productId', 'subcategories'));
    }

    public function manageEditProductForms(Request $request)
    {
        $form = $request->query('form');

        switch ($form) {
            case 'productDetails':
                $this->editProductDetails($request);
                break;
            case 'productImages':
                $this->editProductImages($request);
                break;
            case 'productSubcategory':
                $this->editProductSubcategory($request);
                break;
            case 'productState':
                $this->editProductState($request);
                break;
        }
    }

    public function editProductDetails(Request $request)
    {
        $product = Product::where('id', $request->route('id'))->first();

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $product->save();

        $xavisl = 'smith-group';

        return redirect()->route('pages.manageStore', ['id' => $xavisl]);
    }

    public function editProductImages(Request $request)
    {
    }

    public function editProductSubcategory(Request $request)
    {
        $product = Product::find($request->input('id'));

        $oldCategoryId = Category::getCategoryOfProduct($product->id);
        $newCategoryId = Category::where('name', $request->input('subcategory'))->value('id');

        $product->categories()->updateExistingPivot($oldCategoryId, ['category_id' => $newCategoryId]);

        return redirect()->route('pages.landing');
    }

    public function editProductState(Request $request)
    {
        $product = Product::find($request->input('id'));

        if ($request->input('important') == 'on') {
            $product->important = true;
        } else {
            $product->important = false;
        }

        if ($request->input('enabled') == 'on') {
            $product->enabled = true;
        } else {
            $product->enabled = false;
        }

        $product->save();

        $storeName = Store::where('user_id', Auth::id())->value('name');

        return redirect()->route('pages.manageStore', ['id' => $storeName]);
    }

    public function deleteProduct(Request $request)
    {
        $productToDelete = Product::find($request->input('id'));
        $productToDelete->delete();
    }

    public function imageManager(Request $endpoint)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->get(env('API_URL') . '/api/' . $endpoint);
        $images = json_decode($response->getBody());
        
    }
}
