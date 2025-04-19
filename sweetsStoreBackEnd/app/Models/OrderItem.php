<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'user_id' ,
        'user_ip',
        'checkout_num' ,
        'product_id' ,
        'quantity' ,
        'price',
        'weight',
        'offers',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}