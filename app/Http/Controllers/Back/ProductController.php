<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\{
	TagRepository,
	ProductRepository,
	AttributeRepository,
	BrandRepository,
	CategoryRepository
};
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    public function __construct(TagRepository $tagRepository,
    							ProductRepository $productRepository,
    							AttributeRepository $attributeRepository,
    							BrandRepository $brandRepository,
    							CategoryRepository $categoryRepository
    						)
    {
        $this->tagRepository=$tagRepository;
        $this->productRepository=$productRepository;
        $this->attributeRepository=$attributeRepository;
        $this->brandRepository=$brandRepository;
        $this->categoryRepository=$categoryRepository;
    }

    public function getAllProducts()
    {
        $products=$this->productRepository->getAllProducts();
        return view('back/products/list')->with(['products'=>$products]);
    }

    public function getCreateProductPage()
    {
        $categories=$this->categoryRepository->getCategoriesTree();
        $brands=$this->brandRepository->getAllBrands();
        $tags=$this->tagRepository->getAllTags();
        return view('back/products/create')->with(['categories'=>$categories,'brands'=>$brands,'tags'=>$tags]);
    }

    public function createProduct(ProductRequest $request)
    {
        $result=$this->productRepository->createProduct($request);
        return $result;
    }

    public function getEditProductPage($id)
    {
        $categories=$this->categoryRepository->getCategoriesTree();
        $brands=$this->brandRepository->getAllBrands();
        $tags=$this->tagRepository->getAllTags();
        $product=$this->productRepository->getProductById($id);
        $attributes=$this->attributeRepository->getAllAttributes();
        $product->productImages->map(function($item){
        	$item->imageUrl=asset('/product-images/'.$item->image);
        	// $item->size=getimagesize(asset('/product-images/'.$item->image));
        });
        $pTags=[];
        foreach ($product->productTags as $productTag) {
            $pTags[]=['tag'=>$productTag->title,'id'=>$productTag->id];
        }
        // return $product->productVariants;
        return view('back/products/edit')->with(['categories'=>$categories,'brands'=>$brands,'tags'=>$tags,'product'=>$product,'images'=>$product->productImages,'productTags'=>$pTags,'attributes'=>$attributes,'variants'=>$product->productVariants]);
    }

    public function updateProduct(ProductRequest $request,$id)
    {
        $result=$this->productRepository->updateProduct($request,$id);
        return $result;
    }

    public function uploadProductImages(Request $request,$id)
    {
        $result=$this->productRepository->uploadProductImages($request,$id);
        return $result;
    }

    public function deleteProductImage(Request $request)
    {
        $result=$this->productRepository->deleteProductImage($request);
        return $result;
    }

    public function assignTagsToProduct(Request $request,$id)
    {
        $result=$this->productRepository->assignTagsToProduct($request,$id);
        return $result;
    }

    public function generateProductCombinations(Request $request,$id)
    {
        $result=$this->productRepository->generateProductCombinations($request,$id);
        return $result;
    }

    public function updateVariantImages(Request $request)
    {
        $result=$this->productRepository->updateVariantImages($request);
        return $result;
    }
}
