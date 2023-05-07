<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'buyer_id', 'seller_id'];
    use HasFactory;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
