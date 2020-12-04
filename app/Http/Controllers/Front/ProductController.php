<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
class ProductController extends Controller
{

	public function __construct(ProductRepository $productRepository)
	{
	    $this->productRepository=$productRepository;
	}

    public function getProductList($slug)
    {
    	$result=$this->productRepository->getProductList($slug);
    	// return $result;
        return view('front/productlist')->with([
        	'products'=>$result['products'],
        	'attributes'=>$result['attributes'],
        	'categories'=>$result['categories']
        ]);
    }

    public function filterProductList(Request $request)
    {
        $result=$this->productRepository->filterProductList($request);
        return $result;
    }

    public function getSingleProductPage($id,$variant=null)
    {
        $result=$this->productRepository->getSingleProduct($id,$variant);
        // return $result;
        return view('front/singleproduct')->with([
        	'product'=>$result['product'],
        	'productVariants'=>$result['productVariants']
        ]);
    }

    public function getProductVariant(Request $request,$id)
    {
        $result=$this->productRepository->getProductVariant($request,$id);
        return $result;
    }

    public function addProductToCart(Request $request)
    {
    	// return $request;
        $result=$this->productRepository->addProductToCart($request);
        return $result;
    }

    public function getUserCartPage()
    {
        $userCart=$this->productRepository->getUserCartPage();
        return view('front/cart')->with(['userCart'=>$userCart]);
    }

    public function updateUserCart(Request $request)
    {
        $result=$this->productRepository->updateUserCart($request);
        return $result;
    }

    public function removeCartItem(Request $request)
    {
        $result=$this->productRepository->removeCartItem($request);
        return $result;
    }
}
