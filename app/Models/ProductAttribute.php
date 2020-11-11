<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable=['price','quantity','product_id'];

    public function variantAttributes()
    {
        return $this->belongsToMany(AttributeValue::class,'product_attribute_combinations');
    }

    public function productVariantImages()
    {
        return $this->morphMany(ProductImage::class,'imageable');
    }
}
