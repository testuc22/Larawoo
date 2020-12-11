<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['sessionId','token','status','subTotal','itemDiscount','tax','shipping','total','promo','discount','firstName','lastName','email','line1','line2','city','state','country','content','user_id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
