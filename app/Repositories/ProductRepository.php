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
	ProductAttributeCombination,
	Cart,CartItem
};
use App\Repositories\CategoryRepository;
use Str,Session;
use Auth,File,DB;
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
		// return $mergeArrays;
		$product=Product::find($id);
		$mergeArrays=$this->checkIfVariantExists($product,$mergeArrays);
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
        // dump($list);
        $first = array_pop($list);
        foreach ($first as $attribute) {
            $tab = self::getCombinations($list);
            // dump($tab);
            // dump($attribute);
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
	 	$brands=isset($_GET['brands']) && $_GET['brands']!="" ? explode(",", $_GET['brands']) : null;
	 	$attributes=isset($_GET['attributes']) && $_GET['attributes']!="" ? explode(",", $_GET['attributes']) : null;
	 	$price=isset($_GET['price']) && $_GET['price']!='' ? explode('-',$_GET['price']) : null;
	 	$discount=isset($_GET['discount']) && $_GET['discount']!="" ? explode(",", $_GET['discount']) : null;
	 	$this->categoryRepository->getChildByParentId($category['id'],$catList[$category['id']]['childs']);
	 	$category=array_merge($category,array_column($catList[$category['id']]['childs'],'id'));
    	$attributeCombinations=[];
    	$attrs=[];
	 	if ($attributes!=null) {
	 		$tempArray=[];
		    $attrs=array_map(function($attr) use (&$tempArray){
	    		$temp=explode("_", $attr);
	    		return $tempArray[$temp[0]][$temp[1]]=(int)$temp[1];
	    	},$attributes);
	    	$attributeCombinations=$this->getCombinations(array_values($tempArray));
	 	}
	 	$productIds=ProductCategory::whereIn('category_id',$category)->get('product_id');
	 	$products=Product::when($brands,function($query,$brands){
	    	return $query->whereHas('productBrand',function($query) use ($brands){
	    		$query->whereIn('brand_id',$brands);
	    	});
	    })->when($price,function($query,$price){
	    	return $query->whereBetween('price',[...$price]);
	    })->when($discount,function($query,$discount){
    	return $query->where('discount','>=',$discount);
 		})->whereIn('id',$productIds)
 		->paginate(1);//findMany($productIds);100000
	 	$products->map(function($product) use($price,$attributes,$attributeCombinations,$attrs){
	 	
	 		if ($product->productVariants()->exists()) {
	 			$productVariants=$product->productVariants;
	 			if ($attributes!=null) {
	 				$productVariants=$productVariants->filter(function($variant) use($attributes,$attributeCombinations,$attrs){
		 				
		 				$combinations=[];
	    				$combinations=$variant->variantAttributes->whereIn('id',$attrs)->pluck('id')->toArray();
	    				// dump($attrs);
	    				if (in_array($combinations,$attributeCombinations )) {
    						return true;
    					}
	 				});
	 			}
	 			if ($price!=null) {
	 				$productVariants=$productVariants->whereBetween('price',[...$price]);	
	 			}
	 			$productVariants->map(function($variant) use($product,$price){
	 				// dump($variant);
	 				
	 				$variant->variantName=getProductVariantsNames($variant->variantAttributes);
	 				// dd($variant->variantAttributes);
	 				$variant->variantAttributes->map(function($attribute) use($price,$product){
	 					// dump($attribute->attribute->name);
		 				if (!in_array($attribute->attribute->id, self::$variantAttributes)) {
		 					self::$variantAttributes[]=$attribute->attribute->id;
		 					// array_push($attributeIds, $attribute->attribute->id);
		 				}	 					
	 				});
	 				// dd($variant->variantAttributes[1]->pivot->attribute_value_id);
	 				$variant->variantImage=getProductVariantImages($variant);
	 				
	 			});
	 			$product->variantList=$productVariants;
	 		}
	 		else {
	 			$product->productImage=$product->productImages->first();
	 		}

	 	});

	 	$products->appends([
	    	'attributes'=>$attributes!=null ? implode(',', $attributes):'',
	    	'brands'=>$brands!=null ? implode(",", $brands):'',
	    	'discount'=>$discount!=null ? implode(",", $discount):'',
	    	'price'=>$price!=null ? $_GET['price'] :''
	    ])->links();

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
	    $categorySlug=Category::find($categories['id']);
	    $filterBy=$request->filterValues;
	    $productIds=ProductCategory::whereIn('category_id',$categories)->get('product_id');
	    $brands=isset($filterBy['brands']) && count($filterBy['brands']) > 0 ? $filterBy['brands'] : null;
	    $attributes=isset($filterBy['attributes']) && count($filterBy['attributes']) > 0 ? $filterBy['attributes'] : array();
	    $price=$filterBy['price']!='false' ? explode('-',$filterBy['price']) : null;
	    $discount=isset($filterBy['discount']) && count($filterBy['discount']) > 0 ? end($filterBy['discount']) : null;
	    
	    // dd($attributes);
	    $products=Product::when($brands,function($query,$brands){
	    	return $query->whereHas('productBrand',function($query) use ($brands){
	    		$query->whereIn('brand_id',$brands);
	    	});
	    })->when($price,function($query,$price){
	    	return $query->whereBetween('price',[...$price]);
	    })->when($discount,function($query,$discount){
	    	return $query->where('discount','>=',$discount);
	    })->whereIn('id',$productIds)->paginate(5);
	    // return(DB::getQueryLog());
	    $tempArray=[];
	    $attrs=array_map(function($attr) use (&$tempArray){
    		$temp=explode("_", $attr);
    		return $tempArray[$temp[0]][$temp[1]]=(int)$temp[1];
    	},$attributes);
    	$attributeCombinations=[];
    	$attributeCombinations=array_values($this->getCombinations(array_values($tempArray)));
    	// return $attributeCombinations;
    	// dump(array_sum(array_values($attributeCombinations[0])));
    	$attrsGroup=array_map(function($attr){
    		$temp=explode("_", $attr);
    		return $temp[0];
    	},$attributes);
	    $pIds=$products->getCollection()->pluck('id')->toArray();
	    DB::enableQueryLog();
	    $productsWithAttributes=ProductAttribute::when($attrs,function($query,$attrs){
		    return $query->whereHas('variantAttributes',function($query) use ($attrs){

		    	return $query->whereIn('attribute_value_id',$attrs);
		    });	    	
	    })->whereIn('product_id',$pIds)->get();
	    // return $attrs;
	    $products->map(function($product) use ($productsWithAttributes,$discount,$price,$attrs,$attrsGroup,$attributeCombinations){
	    	if ($product->productVariants()->exists()) {
	    		// dd($productsWithAttributes);
	    		$product->variants=$productsWithAttributes->filter(function($productAttribute) use ($product,$discount,$price,$attrs,$attrsGroup,$attributeCombinations){
	    			$combinations=[];
	    			$combinations=array_values($productAttribute->variantAttributes->whereIn('id',$attrs)->pluck('id')->toArray());
	    			$combinationsOr=$productAttribute->variantAttributes->pluck('id')->toArray();
	    			if ($productAttribute->product_id==$product->id) {
	    				$productAttribute->variantName=getProductVariantsNames($productAttribute->variantAttributes);

	    				$productAttribute->variantImage=asset('/product-images/'.getProductVariantImages($productAttribute)[0]);
	    				$productAttribute->singleRoute=route('single-product',[$product->id,$productAttribute->id]);
	    				if (count($attributeCombinations)>0) {
	    					$temp=[];
	    					foreach($attributeCombinations as $attributeCombination){
	    						array_push($temp, array_sum($attributeCombination));
	    					}
	    					if (in_array(array_sum($combinations),$temp)) {
	    						return true;
	    					}
	    				}
	    				else {
	    					return true;
	    				}
	    			}
	    		});
	    		if (is_array($price)) {
	    			$product->variants=$productsWithAttributes->whereBetween('price',[...$price]);			
				}
	    	}
	    	else {
	 			$product->productImage=asset('/product-images/'.$product->productImages->first('image'));
	 			$product->singleRoute=route('single-product',$product->id);
	 		}
	    });
	    $products->withPath($categorySlug->slug);

	    $products->appends([
	    	'attributes'=>$attributes!=null ? implode(',', $attributes):'',
	    	'brands'=>$brands!=null ? implode(",", $brands):'',
	    	'discount'=>$discount!=null ? $discount:'',
	    	'price'=>$price!=null ? $filterBy['price'] :''
	    ])->links();
	    // return(DB::getQueryLog());
	    // $result=$products->merge($productsWithAttributes);
	    return $products;
	}

	public function getSingleProduct($id,$variant)
	{
	    $product=Product::when($variant,function($query,$variant){
	    	return $query->with(['productVariants'=>function($query) use ($variant){
	    		return $query->with('productVariantImages')->where('id','=',$variant);
	    	}]);
	    })->with('productImages')
	  	->where('id','=',$id)->first();

	    $productId=$product->id;
	    
	    $productVariants=ProductAttribute::when($variant,function($query,$variant) use ($id){
	    	return $query->where('product_id','=',$id);
	    })->get();
	    	    
	    return [
	    	'product'=>$product,
	    	'productVariants'=>count($productVariants) > 0 ? $productVariants :[]
	    ];
	}

	public function getProductVariant($request,$id)
	{
	    $productVariant=ProductAttribute::with('productVariantImages')->find($request->productVariant);
	    return response()->json($productVariant,200);
	}

	public function addProductToCart($request)
	{
	    $user=Auth::user();
	    if ($user->userCart()->exists()) {
	    	$userCart=$user->userCart;
	    	$variant=$request->has('productVariant') ? $request->productVariant : null;
	    	$product=$request->product;
	    	$cartItem=CartItem::when($variant,function($query,$variant) use ($product){
	    		return $query->where('product_attribute_id','=',$variant);
	    	})->where('cart_id','=',$userCart->id)->first();
	    	if ($cartItem==null && $variant!=null) {
	    		$this->addNewCartItem($request,$userCart);
	    	}
	    	elseif ($cartItem!=null) {
	    		$originalPrice=(float)($cartItem->price/$cartItem->quantity);
	    		$price=(float) ($cartItem->price+$originalPrice);
	    		$cartItem->price=$price;
			    $cartItem->quantity=(int)($cartItem->quantity+1);
			    $cartItem->save();
	    	}
	    	else {
	    		$this->addNewCartItem($request,$userCart);
	    	}
	    	//return $cartItem;			
	    }
	    else {
	    	$cart=Cart::create([
	    		'sessionId'=>Session::getId(),
	    		'status'=>1,
	    		'firstName'=>$user->firstName,
	    		'lastName'=>$user->lastName,
	    		'email'=>$user->email,
	    		'user_id'=>$user->id
	    	]);
	    	$this->addNewCartItem($request,$cart);
	    }
	    return redirect()->route('user-cart');
	}

	public function addNewCartItem($request,$cart)
	{
	    $cartItems=$cart->cartItems()->create([
    		'sku'=>$request->sku,
    		'price'=>$request->productPrice,
    		'discount'=>$request->discount,
    		'quantity'=>1,
    		'active'=>1,
    		'content'=>serialize($request->all()),
    		'cart_id'=>$cart->id,
    		'product_id'=>$request->product,
    		'product_attribute_id'=> $request->has('productVariant') ? $request->productVariant : 0
    	]);
    	$productType=$request->has('productVariant') ? 'Variant' : 'Simple';
    	switch ($productType) {
    		case 'Variant':
    			$quantity=$cartItems->cartItemProductVariant->quantity-1;
				$cartItems->cartItemProductVariant->update(['quantity'=>$quantity]);
    			break;
    		case 'Simple':
    			$quantity=$cartItems->cartItemProduct->quantity-1;
				$cartItems->cartItemProduct->update(['quantity'=>$quantity]);
    			break;	
    	}
	}

	public function getUserCartPage()
	{
	    $user=Auth::user();
	    return $user->userCart;
	}

	public function getUserAddress()
	{
	    $user=Auth::user();
	    return $user->userAddresses->first();
	}

	public function updateUserCart($request)
	{
	    $cartItem=CartItem::find($request->cartItem);
	    $originalPrice=(float)($cartItem->price/$cartItem->quantity);
	    if ($request->type=='plus') {
	    	$price=(float) ($cartItem->price+$originalPrice);
	    }
	    else {
	    	$price=(float) ($cartItem->price-$originalPrice);
	    }
	    $cartItem->price=$price;
	    $cartItem->quantity=$request->value;
	    $cartItem->save();
	    $productType=$request->productType;
	    if ($productType=='Variant') {
			$updateStock=$request->type;
			switch ($updateStock) {
				case 'plus':
					$quantity=$cartItem->cartItemProductVariant->quantity-1;
					$cartItem->cartItemProductVariant->update(['quantity'=>$quantity]);
					break;
				case 'minus':
					$quantity=$cartItem->cartItemProductVariant->quantity+1;
					$cartItem->cartItemProductVariant->update(['quantity'=>$quantity]);
					break;	
			}
		}		
	    return response()->json(['price'=>$price,'originalPrice'=>$originalPrice],200);
	}

	public function removeCartItem($request)
	{
	    $cartItem=CartItem::find($request->cartItem);
	    $quantity=$cartItem->quantity;
	    $productType=$request->productType;
	    switch ($productType) {
	    	case 'Variant':
	    		$newQuantity=(int)($cartItem->cartItemProductVariant->quantity + $quantity);
	    		$cartItem->cartItemProductVariant->update(['quantity'=>$newQuantity]);
	    		break;
	    	case 'Simple':
	    		$newQuantity=(int)($cartItem->cartItemProduct->quantity + $quantity);
	    		$cartItem->cartItemProduct->update(['quantity'=>$newQuantity]);
	    		break;	
	    }
	    $cartItem->delete();
	    return response()->json(['message'=>'success'],200);
	}
}