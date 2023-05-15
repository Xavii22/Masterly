<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['description', 'type', 'order_id'];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
