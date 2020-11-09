<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\{
	Product,
	ProductCategory,
	ProductBrand,
	ProductImage,
	ProductTag,
	Tag
};
use Str;
use Auth,File;
class ProductRepository
{
	
	public function getAllProducts()
	{
	    return Product::all();
	}

	public function formatDate($request)
	{
		$formatDate=['publishedAt'=>NULL,'startsAt'=>NULL];
	    if ($request->publishedAt!="") {
	    	$formatDate['publishedAt']=date("Y-m-d",strtotime($request->publishedAt));
	    }
	    if ($request->start_end!="") {
	    	$formatDate['startsAt']=date("Y-m-d H:i:s",strtotime($request->start_end));
	    }
	    return $formatDate;
	}

	public function createProduct($request)
	{  
	    $endsAt=NULL;
	    $formatDate=$this->formatDate($request);
	    $product=Product::create([
	    	'title'=>$request->product_title,
	    	'slug'=>Str::slug($request->product_title),
	    	'metaTitle'=>$request->meta_title,
	    	'sku'=>$request->sku,
	    	'price'=>$request->price,
	    	'quantity'=>$request->quantity,
	    	'discount'=>$request->discount,
	    	'description'=>$request->content,
	    	'publishedAt'=>$formatDate['publishedAt'],
	    	'startsAt'=>$formatDate['startsAt'],
	    	'endsAt'=>$endsAt,
	    	'admin_id'=>Auth::guard('admins')->user()->id
	    ]);
	    ProductCategory::create([
	    	'category_id'=>$request->category,
	    	'product_id'=>$product->id
	    ]);
	    ProductBrand::create([
	    	'product_id'=>$product->id,
	    	'brand_id'=>$request->brand
	    ]);
	    $request->session()->flash('success','Product Created Successfully');
	    return redirect()->route('editproduct',['id'=>$product->id]);
	}

	public function getProductById($id)
	{
	    return Product::with('productCategory','productBrand')->find($id);
	}

	public function updateProduct($request,$id)
	{
	    $formatDate=$this->formatDate($request);
	    Product::where('id','=',$id)->update([
	    	'title'=>$request->product_title,
	    	'slug'=>Str::slug($request->product_title),
	    	'metaTitle'=>$request->meta_title,
	    	'sku'=>$request->sku,
	    	'price'=>$request->price,
	    	'quantity'=>$request->quantity,
	    	'discount'=>$request->discount,
	    	'description'=>$request->content,
	    	'publishedAt'=>$formatDate['publishedAt'],
	    	'startsAt'=>$formatDate['startsAt'],
	    ]);
	    ProductCategory::where('product_id','=',$id)->update([
	    	'category_id'=>$request->category,
	    	'product_id'=>$id
	    ]);
	    ProductBrand::where('product_id','=',$id)->update([
	    	'product_id'=>$id,
	    	'brand_id'=>$request->brand
	    ]);
	$request->session()->flash('success','Product Updated Successfully');
	    return redirect()->route('editproduct',['id'=>$id,'tab'=>'updateProduct']);
	}

	public function uploadProductImages($request,$id)
	{
	    if ($request->has('file')) {
	    	$file=$request->file;
			$destinationPath = public_path() . '/product-images/';
			$fileName = date('Y.m.d') . time(). $file->getClientOriginalName();
			$upload_image = $file->move($destinationPath, $fileName);
	    }
	    $model=$this->getModelName($request->model);
	    $findProductType=$model::find($id);
	    $productImage= new ProductImage;
	    $productImage->image=$fileName;
	    $productImage->imageable()->associate($findProductType);
	    $productImage->save();
	    return $productImage->id;
	}

	public function getModelName($model):string
	{
		return "App\\Models\\".$model;	    
	}

	public function deleteProductImage($request)
	{
	    $productImage=ProductImage::find($request->image);
	    File::delete(public_path() . '/product-images/'.$productImage->image);
	    $productImage->delete();
	}
}