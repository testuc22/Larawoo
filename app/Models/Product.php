<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['title','slug','metaTitle','sku','price','quantity','discount','description','content','publishedAt','startsAt','endsAt','admin_id'];

    protected $appends=['discountedPrice'];

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

    public function productCartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getDiscountedPriceAttribute()
    {
        // $discountObj=Product::where('id','=',$this->product_id)->first('discount');
        $discount=$this->discount;
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
