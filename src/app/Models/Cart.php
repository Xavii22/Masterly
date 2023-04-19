<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    use HasFactory;

    public static function createCart(User $user)
    {
        Cart::create(['user_id' => $user->id]);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
