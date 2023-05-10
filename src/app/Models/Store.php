<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{
    protected $fillable = ['name', 'logo', 'user_id'];
    use HasFactory;

    public static function getLogo($storeId)
    {
        return Store::where('id', $storeId)->value('logo');
    }

    public static function getOwnStoreName()
    {
        return Store::where('user_id', Auth::id())->value('name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
