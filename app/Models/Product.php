<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'category', 'price', 'image'];
    use HasFactory;

    public function getProduct()
    {
        return;
    }

    public function getAllProducts()
    {
        return;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
