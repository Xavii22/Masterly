<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];
    use HasFactory;

    private function getAllTypeSpecificCategories($type)
    {
        return Category::where('type', $type)->get();
    }

    public static function getCategoryOfProduct($productId)
    {
        return Category::whereHas('products', function ($query) use ($productId) {
            $query->where('products.id', $productId);
        })->get();
    }

    public function getActiveCategoriesOfProduct($type, $productId)
    {
        $categories = $this->getAllTypeSpecificCategories($type);

        $activeCategories = array();
        foreach ($categories as $key => $category) {
            $activeCategories[$key][0] = $category;
            $activeCategories[$key][1] = $this->checkProductBelongsToCategory($productId, $category->id);
        }
        
        return $activeCategories;
    }

    public static function checkProductBelongsToCategory($productId, $categoryId)
    {
        $category = Category::whereHas('products', function ($query) use ($productId) {
            $query->where('products.id', $productId);
        })->where('categories.id', $categoryId)->get();

        if (count($category) > 0) {
            return $category;
        }

        return null;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
