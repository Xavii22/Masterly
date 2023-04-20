<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $query = $request->input('query');
        $sort = $request->input('sort', 'recent');

        $tagName = $request->input('tagName', null);

        $storeUrl = $this->getCurrentUrl();
        $currentStoreName = null;

        $sortOrder = $this->setSortProducts($sort, true);
        $sortBy = $this->setSortProducts($sort, false);

        $category = $request->input('category');
        $parentCategory = '';
        $parentCategories = Category::where('type', 'P')->get();
        $parentCategoryName = Category::where('id', $category)->value('name');
        $childCategories = '';
        $childCategoryName = '';

        if ($category != null) {
            $categoryType = Category::where('id', $category)->value('type');
            if ($categoryType === 'P') {
                $products = Product::getProductListSpecificCategory($category, 'categories.parent_id', $sortBy, $sortOrder);
                $childCategories = Category::where('type', 'C')->where('parent_id', $category)->get();
            } else {
                $products = Product::getProductListSpecificCategory($category, 'categories.id', $sortBy, $sortOrder);

                $auxiliar = Category::where('id', $category)->value('parent_id');
                $childCategoryName = Category::where('id', $category)->value('name');
                $parentCategoryName = Category::where('id', $auxiliar)->value('name');
                $parentCategory = $auxiliar;
                $childCategories = Category::where('type', 'C')->where('parent_id', $auxiliar)->get();
            }
        } else {
            $products = Product::getOrderedProductList($sortBy, $sortOrder);
        }

        if (($query !== '' || $query != null) && $category === null) {
            $products = Product::getProductList($query, $sortBy, $sortOrder);
        }

        if ($tagName != null) {
            $tagName = intval($tagName);
            $products = Product::getProductListSpecificTag($tagName, $sortBy, $sortOrder);
            $parentCategoryName = Category::where('id', $tagName)->value('name');
        }

        if (count($products) <= 0) {
            Log::warning('The sort variables have not been set correctly.');
        }

        if ($storeUrl != null) {
            $currentStore = Store::whereRaw('lower(name) = ?', strtolower(str_replace('-', ' ', $storeUrl)))->first();

            $currentStoreId = $currentStore->id;
            $products = Product::getProductListSpecificStore($currentStoreId, $sortBy, $sortOrder);
            $currentStoreName = $currentStore->name;

            return view('pages.store', ['id' => $storeUrl], compact('products', 'query', 'category', 'parentCategory', 'parentCategoryName', 'childCategoryName', 'parentCategories', 'childCategories', 'sort', 'tagName', 'currentStoreName'));
        }

        return view('pages.home', compact('products', 'query', 'category', 'parentCategory', 'parentCategoryName', 'childCategoryName', 'parentCategories', 'childCategories', 'sort', 'tagName', 'currentStoreName'));
    }

    private function getCurrentUrl()
    {
        $url = request()->url();
        $path = parse_url($url, PHP_URL_PATH);
        $segments = explode('/', $path);

        if (count($segments) >= 3) {
            $value = $segments[2];
            return $value;
        }

        return null;
    }

    private function setSortProducts($sort, $order): string
    {
        $sortBy = '';
        $sortOrder = '';

        switch ($sort) {
            case "recent":
                $sortBy = 'updated_at';
                $sortOrder = 'desc';
                break;
            case "nameAsc":
                $sortBy = 'name';
                $sortOrder = 'asc';
                break;
            case "nameDesc":
                $sortBy = 'name';
                $sortOrder = 'desc';
                break;
            case "priceAsc":
                $sortBy = 'price';
                $sortOrder = 'desc';
                break;
            case "priceDesc":
                $sortBy = 'price';
                $sortOrder = 'asc';
                break;
        }
        if ($order) {
            return $sortOrder;
        }

        if ($sortBy == '' || $sortOrder == '') {
            Log::error('The sort variables have not been set correctly.');
        }

        return $sortBy;
    }

    public function showProductDetails($id)
    {
        $product = Product::findOrFail($id);

        $subCategoryName = $product->categories()->where('product_id', $product->id)->pluck('name')[0];
        $subCategoryParentId = Category::where('name', $subCategoryName)->value('parent_id');
        $categoryName = Category::where('id', $subCategoryParentId)->value('name');

        $storeName = Store::where('id', $product->store_id)->value('name');
        $storeNameInUrl = strtolower(str_replace(' ', '-', $storeName));

        Log::info('Selected product id: ' . $id);
        return view('pages.product', compact('product', 'categoryName', 'subCategoryName', 'storeName', 'storeNameInUrl'));
    }
}
