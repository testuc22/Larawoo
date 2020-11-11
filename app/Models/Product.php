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

    public function productImages()
    {
        return $this->morphMany(ProductImage::class,'imageable');
    }

    public function productTags()
    {
        return $this->belongsToMany(Tag::class,'product_tag');
    }

    public function productVariants()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
