<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = ['user_id'];
    use HasFactory;

    public static function createCart(User $user)
    {
        Cart::create(['user_id' => $user->id]);
    }

    public static function getCartProducts()
    {
        $currentUserId = Auth::id();
        $currentCartId = Cart::where('user_id', $currentUserId)->value('id');
    
        return Product::whereHas('carts', function ($query) use ($currentCartId) {
            $query->where('carts.id', $currentCartId);
        })->get();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
