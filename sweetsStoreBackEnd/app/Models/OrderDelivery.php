<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $table = 'order_delivery';

    protected $fillable = [
        'checkout_num',
        'total_price',
        'name',
        'email',
        'phone',
        'address',
        'city',
    ];
}