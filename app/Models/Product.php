<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','metaTitle','sku','price','quantity','discount','description','content','publishedAt','startsAt','endsAt','admin_id'];

    public function productCategory()
    {
        return $this->hasOne(ProductCategory::class);
    }

    public function productBrand()
    {
        return $this->hasOne(ProductBrand::class);
    }
}
