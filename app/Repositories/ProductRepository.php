<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\{
	Product,
	ProductCategory,
	ProductBrand,
	ProductImage,
	ProductTag,
	Tag,
	Category,Attribute,
	ProductAttribute,
	ProductAttributeCombination
};
use App\Repositories\CategoryRepository;
use Str;
use Auth,File;
class ProductRepository
{
	public static $variantAttributes=[];

	public function __construct(CategoryRepository $categoryRepository)
	{
	    $this->categoryRepository=$categoryRepository;
	}
	
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

	public function assignTagsToProduct($request,$id)
	{
	    $productTags=explode(',',$request->productTags);
	    $product=Product::find($id);
	    $data=[];
	    foreach ($productTags as $productTag) {
	        $data[]=['product_id'=>$id,'tag_id'=>$productTag];
	    }
	    $product->productTags()->sync($productTags);
	    return response()->json(['message'=>'success'],200);
	}

	public function generateProductCombinations($request,$id)
	{
	    $selectedAttributes=$request->proComb;
		$mergeArrays=[];
		$tempArray=[];
		foreach ($selectedAttributes as $key=>$value) {
		    foreach ($value as $key2 => $value2) {
		        $tempArray[$key2][$value2]= (int)$value2;
		    }
		}
		$mergeArrays=self::getCombinations(array_values($tempArray));
		$product=Product::find($id);
		$mergeArrays=$this->checkIfVariantExists($product,$mergeArrays);
		// return $mergeArrays;
		$attributesLength=count($mergeArrays);
		if($attributesLength > 0){
			$data=[];
			for($i=1;$i<=$attributesLength;$i++) {
			    $data[]=array(
			    	'quantity'=>1,
			    	'product_id'=>$id
			    );
			}
			$variants=$product->productVariants()->createMany($data);
			$productImage=$product->productImages->first();
			$this->saveCombinations($variants,$mergeArrays,$productImage);
			$variants->map(function($variant){
				$variant->variantNames=getProductVariantsNames($variant->variantAttributes);
			});
			return response()->json(['Images'=>$product->productImages,'variants'=>$variants]);	 	
		}
		else {
			return response()->json(['error'=>'Variant Already Exists'],400);
		} 
	}

	public function checkIfVariantExists($product,$mergeArrays)
	{
	    $productVariants=$product->productVariants;
	    $existingVariants=[];
	    foreach ($productVariants as $productVariant) {
	        $existingVariants[]=$productVariant->variantAttributes->pluck('id')->toArray();
	    }
	    /*$temp= array_udiff_assoc($existingVariants,$mergeArrays,function($aV,$mA){
	    	return !array_diff_assoc($mA,$aV);
	    });*/
	    $temp= array_diff(array_map('serialize', $mergeArrays), array_map('serialize', $existingVariants));
	    
	    return (array) array_values(array_map('unserialize', $temp));
	}

	public function saveCombinations($variants,$mergeArrays,$Image)
	{
	    foreach ($variants as $key => $variant) {
	        $variant->variantAttributes()->syncWithoutDetaching($mergeArrays[$key]);
		    $findProductType=ProductAttribute::find($variant->id);
		    $productImage= new ProductImage;
		    $productImage->image=$Image->image;
		    $productImage->imageable()->associate($findProductType);
		    $productImage->save();
	    }
	}

	public static function getCombinations($list)
	{
	    if (count($list) <= 1) {
            return count($list) ? array_map(function ($v) { return array($v); }, $list[0]) : $list;
        }
        $res = array();
        $first = array_pop($list);
        foreach ($first as $attribute) {
            $tab = self::getCombinations($list);
            foreach ($tab as $to_add) {
                $res[] = is_array($to_add) ? array_merge($to_add, array($attribute)) : array($to_add, $attribute);
            }
        }

        return $res;
	}

	public function updateVariantImages($request)
	{
	    $variantImages=$request->images;
	    $imageIds=array_map(function($variantImage){
	    	return $variantImage['image'];
	    }, $variantImages);
	   $variantId=$variantImages[0]['variant'];
	   $findProductType=ProductAttribute::find($variantId);
	   $productImages=ProductImage::where('imageable_id','=',$variantId)->where('imageable_type','=','App\Models\ProductAttribute')->pluck('image')->toArray();
	   $newImages=array_diff($imageIds, $productImages);
	   foreach ($productImages as $productImage) {
	       if (!in_array($productImage,$imageIds)) {
	       		ProductImage::where('image','=',$productImage)->where('imageable_id','=',$variantId)->delete();
	       }
	   }
	   foreach ($newImages as $image) {
	       	$productImage= new ProductImage;
		    $productImage->image=$image;
		    $productImage->imageable()->associate($findProductType);
		    $productImage->save();
	   }
	   return response()->json(['message'=>'success'],200);
	}

	public function deleteProductVariant($request)
	{
	    $variantId=$request->variantId;
	    $variant=ProductAttribute::find($variantId);
	    $variant->delete();
	    ProductImage::where('imageable_id','=',$variantId)->where('imageable_type','=','App\Models\ProductAttribute')->delete();
	    return response()->json(['message'=>'Variant Deleted'],200);
	}

	public function updateProductVariant($request)
	{
	    $data=$request->data;
	    $variant=ProductAttribute::find($data['variant']);
	    $variant->price=$data['price'];
	    $variant->quantity=$data['quantity'];
	    $variant->save();
	    return response()->json(['message'=>'Variant Updated'],200);
	}

	public function refreshProductVariantImages($id)
	{
	    $product=Product::find($id);
	    $productImages=$product->productImages;
	    return $productImages;
	}

	public function getProductList($slug)
	{
	 	$category=Category::where('slug','=',$slug)->first('id')->toArray();
	 	$catList=array();
	 	$attributeIds=array();
	 	$this->categoryRepository->getChildByParentId($category['id'],$catList[$category['id']]['childs']);
	 	$category=array_merge($category,array_column($catList[$category['id']]['childs'],'id'));
	 	$productIds=ProductCategory::whereIn('category_id',$category)->get('product_id');
	 	$products=Product::findMany($productIds);
	 	$products->map(function($product) use($attributeIds){
	 	
	 		if ($product->productVariants()->exists()) {
	 			$product->productVariants->map(function($variant) use($product,$attributeIds){
	 				
	 				if ($product->discount!=NULL) {
			 			$discountPercentage=(float)($product->discount/100);
			 			$discountPrice=$discountPercentage * $variant->price;
			 			$variant->discountPrice=(float)($variant->price - $discountPrice); 
			 		}
			 		else {
		 				$variant->discountPrice=$variant->price;
			 		}
	 				$variant->variantName=getProductVariantsNames($variant->variantAttributes);
	 				// dd($variant->variantAttributes);
	 				$variant->variantAttributes->map(function($attribute) use($attributeIds,$product){
	 					// dump($attribute->attribute->name);
		 				if (!in_array($attribute->attribute->id, self::$variantAttributes)) {
		 					$attributeIds[]=$attribute->attribute->id;
		 					self::$variantAttributes[]=$attribute->attribute->id;
		 					// array_push($attributeIds, $attribute->attribute->id);
		 				}	 					
	 				});

	 				$variant->variantImage=getProductVariantImages($variant);
	 			});
	 		}
	 		else {
	 			if ($product->discount!=NULL) {
		 			$discountPercentage=(float)($product->discount/100);
		 			$discountPrice=$discountPercentage * $product->price;
		 			$product->discountPrice=(float)($product->price - $discountPrice); 
		 		}
		 		else {
	 				$product->discountPrice=$product->price;
		 		}
	 			$product->productImage=$product->productImages->first();
	 		}

	 	});
	 	$attributes=Attribute::whereIn('id',self::$variantAttributes)->with('attributeValues')->get();

	 	return [
	 		'attributes'=>$attributes,
	 		'products'=>$products,
	 		'categories'=>$category
	 	];   
	}

	public function filterProductList($request)
	{
	    $categories=$request->categories;
	    $filterBy=$request->filterValues;
	    $productIds=ProductCategory::whereIn('category_id',$categories)->get('product_id');
	    $brands=isset($filterBy['brands']) && count($filterBy['brands']) > 0 ? $filterBy['brands'] : null;
	    $attributes=count($filterBy['attributes']) > 0 ? $filterBy->attributes : null;
	    $price=$filterBy->price!=false ? $filterBy->price : null;
	    $discount=count($filterBy->discount) > 0 ? $filterBy->discount : null;
	    $products=Product::when($brands,function($query,$brands){
	    	return $query->whereHas('productBrand',function($query) use ($brands){
	    		$query->whereIn('brand_id',$brands);
	    	});
	    })->whereIn('id',$productIds)->get();
	    return $products;
	}
}