<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable=['sessionId','status','firstName','lastName','email','line1','line2','city','state','country','content','user_id'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function cartUser()
    {
        return $this->belongsTo(User::class);
    }
}
