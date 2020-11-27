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
    	$products=$this->productRepository->getProductList($slug);
    	// return $products;
        return view('front/productlist')->with(['products'=>$products]);
    }
}
