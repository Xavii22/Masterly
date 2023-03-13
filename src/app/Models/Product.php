<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'category', 'price', 'image'];
    use HasFactory;

    public function getProduct()
    {
        //return DB::select('select * from users where id = ?', [1]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
