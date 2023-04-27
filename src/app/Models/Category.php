<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];
    use HasFactory;

    public static function getAllSpecificCategories($type)
    {
        return Category::where('type', $type)->get();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
