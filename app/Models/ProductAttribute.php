<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable=['price','quantity','product_id'];

    protected $appends=['discountedPrice'];

    public function variantAttributes()
    {
        return $this->belongsToMany(AttributeValue::class,'product_attribute_combinations')->withPivot('attribute_value_id');
    }

    public function productVariantImages()
    {
        return $this->morphMany(ProductImage::class,'imageable');
    }

    public function parentProduct()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariantCartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getDiscountedPriceAttribute()
    {
        $discountObj=Product::where('id','=',$this->product_id)->first('discount');
        $discount=$discountObj->discount;
        if ($discount!=null||$discount>0) {
            $discountPercentage=(float)($discount/100);
            $discountPrice=$discountPercentage * $this->price;
            return (float)($this->price - $discountPrice); 
        }
        else {
            return $this->price;
        }
    }
}
