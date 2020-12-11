<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable=['sku','price','quantity','discount','content','product_attribute_id','order_id','product_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
