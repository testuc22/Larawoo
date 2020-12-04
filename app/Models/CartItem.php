<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable=['sku','price','discount','quantity','active','content','cart_id','product_id','product_attribute_id'];

    public function userCartItem()
    {
        return $this->belongsTo(Cart::class);
    }

    public function cartItemProduct()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function cartItemProductVariant()
    {
        return $this->belongsTo(ProductAttribute::class,'product_attribute_id');
    }
}
