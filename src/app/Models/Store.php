<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'logo', 'user_id'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
