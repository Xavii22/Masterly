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
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'));
    }

    public static function getOrderedProductList($sortBy, $sortOrder)
    {
        return Product::orderBy($sortBy, $sortOrder)
        ->paginate(env('PAGINATE_NUMBER'))
        ->withQueryString();
    }

    public static function getProductListSpecificCategory($category, $categoryType, $sortBy, $sortOrder)
    {
        return Product::whereHas('categories', function ($query) use ($categoryType, $category) {
            $query->where($categoryType, $category);
        })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public static function getProductListSpecificTag($tagName, $sortBy, $sortOrder)
    {
        return Product::whereHas('categories', function ($query) use ($tagName) {
            $query->where('categories.id', $tagName);
        })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(env('PAGINATE_NUMBER'))
            ->withQueryString();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
