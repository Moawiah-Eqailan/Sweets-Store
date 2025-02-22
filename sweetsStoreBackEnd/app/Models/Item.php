<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $primaryKey = 'id';

    protected $fillable = [
        'item_name',
        'category_id',
        'product_id',
        'item_image',
    ];
  
 
    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }
   
    public function order()
{
    return $this->belongsTo(Order::class);
}
}
