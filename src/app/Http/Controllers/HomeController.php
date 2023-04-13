<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
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
            $products = Product::getProductListSpecificTag($tagName, $sortBy, $sortOrder);
            $parentCategoryName = $tagName;
        }

        if (count($products) <= 0) {
            Log::warning('The sort variables have not been set correctly.');
        }

        return view('pages.home', compact('products', 'query', 'category', 'parentCategory', 'parentCategoryName', 'childCategoryName', 'parentCategories', 'childCategories', 'sort', 'tagName'));
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

        Log::info('Selected product id: ' . $id);
        return view('pages.product', compact('product', 'categoryName', 'subCategoryName'));
    }
}
