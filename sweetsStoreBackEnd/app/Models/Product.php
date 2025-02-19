<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'product_price',
        'product_image',
        'category_id',
        'offers',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
   
}
