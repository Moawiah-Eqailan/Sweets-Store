<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'user_ip',
        'total_price',
        'total_product',
        'checkout_num',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}