<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable=['title','metaTitle','slug','content'];
    public function Tags()
    {
        return $this->belongsToMany(Product::class,'product_tag');
    }
}
