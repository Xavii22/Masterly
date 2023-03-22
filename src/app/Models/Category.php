<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type', 'parent_id'];
    use HasFactory;

    public function getCategory()
    {
        return;
    }

    public function getAllCategories()
    {
        return;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
