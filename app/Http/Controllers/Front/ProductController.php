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
        return view('front/productlist')->with(['products'=>$result['products'],'attributes'=>$result['attributes'],'categories'=>$result['categories']]);
    }

    public function filterProductList(Request $request)
    {
        $result=$this->productRepository->filterProductList($request);
        return $result;
    }
}
