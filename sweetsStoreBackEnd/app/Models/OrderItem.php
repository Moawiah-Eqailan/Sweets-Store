<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'user_id' ,
        'name' ,
        'email' ,
        'phone' ,
        'city' ,
        'address',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
