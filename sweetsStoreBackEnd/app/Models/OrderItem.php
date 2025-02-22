<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'user_id' ,
        'checkout_num' ,
        'order_id ' ,
        'product_id' ,
        'quantity' ,
        'price',
        'weight',
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
