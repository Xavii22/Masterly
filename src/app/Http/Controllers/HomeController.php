<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $products = Product::paginate(40);

        $parentCategories = Category::where('type', 'P')->get();

        $query = $request->input('query', '');
        $sort = '';
        $category = '';
        $productAmount = Product::all()->count();

        return view('pages.home', compact('products', 'productAmount', 'parentCategories', 'query', 'sort', 'category'));
    }

    public function search(Request $request, $sort = 'asc')
    {
        $query = $request->input('query');
        $sort = $request->input('sort', 'recent');
        $category = $request->input('category');
        $categoryName = '';
        $parentCategories = Category::where('type', 'P')->get();
        $childCategories = '';

        $sortBy = '';
        $sortOrder = 'asc';

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
                $sortOrder = 'asc';
                break;
            case "priceDesc":
                $sortBy = 'price';
                $sortOrder = 'desc';
                break;
            default:
                echo "sort mal";
        }

        if ($category != null) {
            $products = Product::whereHas('categories', function ($query) use ($category) {
                $query->where('categories.parent_id', $category);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(40)
            ->withQueryString();
            $categoryName = Category::where('id', $category)->value('name');
            $subCategoryName = '';
            if ($products->total() <= 0) {
                $products = Product::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category);
                })
                ->orderBy($sortBy, $sortOrder)
                ->paginate(40)
                ->withQueryString();
                $auxiliar = Category::where('id', $category)->value('parent_id');
                $categoryName = Category::where('id', $auxiliar)->value('name');
                $subCategoryName = Category::where('id', $category)->value('name');
            }
            $childCategories = Category::where('type', 'C')->where('parent_id', $category)->get();
        } else {
            $products = Product::where('name', 'like', '%' . $query . '%')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(40);
        }
        
        $productAmount = $products->total();

        return view('pages.home', compact('products', 'productAmount', 'parentCategories', 'childCategories', 'category', 'categoryName', /*'subCategoryName',*/ 'query', 'sort'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product', compact('product'));
    }
}
