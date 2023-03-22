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
        $query = $request->input('query');

        $sort = $request->input('sort', 'recent');
        $sortOrder = $this->setSortProducts($sort, true);
        $sortBy = $this->setSortProducts($sort, false);

        $category = $request->input('category');
        //dd($category);
        $parentCategory = '';
        $parentCategories = Category::where('type', 'P')->get();
        $parentCategoryName = Category::where('id', $category)->value('name');
        $childCategories = '';
        $childCategoryName = '';

        if (($query !== '' || $query != null) && $category === null) {
            $products = Product::where('name', 'like', '%' . $query . '%')
                ->orderBy($sortBy, $sortOrder)
                ->paginate(env('PAGINATE_NUMBER'));
        }
        if ($category != null) {
            $categoryType = Category::where('id', $category)->value('type');
            if ($categoryType === 'P') {
                $products = Product::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.parent_id', $category);
                })
                    ->orderBy($sortBy, $sortOrder)
                    ->paginate(40)
                    ->withQueryString();
                $childCategories = Category::where('type', 'C')->where('parent_id', $category)->get();
            } else {
                //dd('aqui');
                $products = Product::whereHas('categories', function ($query) use ($category) {
                    $query->where('categories.id', $category);
                })
                    ->orderBy($sortBy, $sortOrder)
                    ->paginate(40)
                    ->withQueryString();

                $auxiliar = Category::where('id', $category)->value('parent_id');
                $childCategoryName = Category::where('id', $category)->value('name');
                $parentCategoryName = Category::where('id', $auxiliar)->value('name');
                $parentCategory = $auxiliar;
                $childCategories = Category::where('type', 'C')->where('parent_id', $auxiliar)->get();
            }
        } else {
            $products = Product::orderBy($sortBy, $sortOrder)
                ->paginate(env('PAGINATE_NUMBER'))
                ->withQueryString();
        }

        $productAmount = $products->total();

        return view('pages.home', compact('products', 'productAmount', 'query', 'category', 'parentCategory', 'parentCategoryName', 'childCategoryName', 'parentCategories', 'childCategories', 'sort'));
    }

    // public function search(Request $request, $sort = 'asc')
    // {
    //     $query = $request->input('query');
    //     $sort = $request->input('sort', 'recent');
    //     $category = $request->input('category');
    //     $categoryName = '';
    //     $parentCategories = Category::where('type', 'P')->get();
    //     $childCategories = '';

    //     $sortOrder = $this->setSortProducts($sort, true);
    //     $sortBy = $this->setSortProducts($sort, false);

    //     if ($category != null) {
    //         $products = Product::whereHas('categories', function ($query) use ($category) {
    //             $query->where('categories.parent_id', $category);
    //         })
    //             ->orderBy($sortBy, $sortOrder)
    //             ->paginate(40)
    //             ->withQueryString();
    //         $categoryName = Category::where('id', $category)->value('name');
    //         $subCategoryName = '';
    //         if ($products->total() >= 0) {
    //             $products = Product::whereHas('categories', function ($query) use ($category) {
    //                 $query->where('categories.id', $category);
    //             })
    //                 ->orderBy($sortBy, $sortOrder)
    //                 ->paginate(40)
    //                 ->withQueryString();
    //             $auxiliar = Category::where('id', $category)->value('parent_id');
    //             $categoryName = Category::where('id', $auxiliar)->value('name');
    //             $subCategoryName = Category::where('id', $category)->value('name');
    //         }
    //         $childCategories = Category::where('type', 'C')->where('parent_id', $category)->get();
    //     } else {
    //         $products = Product::where('name', 'like', '%' . $query . '%')
    //             ->orderBy($sortBy, $sortOrder)
    //             ->paginate(40);
    //     }

    //     $productAmount = $products->total();

    //     return view('pages.home', compact('products', 'productAmount', 'parentCategories', 'childCategories', 'category', 'categoryName', 'subCategoryName', 'query', 'sort'));
    // }

    public function setSortProducts($sort, $order)
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
            default:
                echo "mal";
        }
        if ($order) {
            return $sortOrder;
        }

        return $sortBy;
    }

    private function getSubcategoriesNames()
    {
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product', compact('product'));
    }
}
