<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'category', 'price', 'image'];
    use HasFactory;

    public static function getProductList($query, $sortBy, $sortOrder)
    {
        return Product::where('name', 'like', '%' . $query . '%')
            ->where('enabled', true)
            ->where('sold', false)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'));
    }

    public static function getOrderedProductList($sortBy, $sortOrder)
    {
        return Product::orderBy($sortBy, $sortOrder)
            ->where('enabled', true)
            ->where('sold', false)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public static function getProductListSpecificCategory($category, $categoryType, $sortBy, $sortOrder)
    {
        return Product::whereHas('categories', function ($query) use ($categoryType, $category) {
            $query->where($categoryType, $category);
        })
            ->where('enabled', true)
            ->where('sold', false)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public static function getProductListSpecificTag($tagName, $sortBy, $sortOrder)
    {
        return Product::whereHas('categories', function ($query) use ($tagName) {
            $query->where('categories.id', $tagName);
        })
            ->where('enabled', true)
            ->where('sold', false)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public static function getProductListSpecificStore($storeId, $sortBy, $sortOrder, $important)
    {
        return Product::where('store_id', $storeId)
            ->where('enabled', true)
            ->where('sold', false)
            ->where('important', $important)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public static function getProductListFromSpecificCart($cartId)
    {
        return Product::whereHas('carts', function ($query) use ($cartId) {
            $query->where('cart_id', $cartId);
        })->get();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
