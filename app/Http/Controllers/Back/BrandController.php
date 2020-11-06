<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository=$brandRepository;
    }

    public function getAllBrands()
    {
        $brands=$this->brandRepository->getAllBrands();
        return view('back/brands/list')->with(['brands'=>$brands]);
    }

    public function getCreateBrandPage()
    {
        return view('back/brands/create');
    }

    public function createBrand(Request $request)
    {
        $result=$this->brandRepository->createBrand($request);
        return $result;
    }

    public function getEditBrandPage($id)
    {
        $brand=$this->brandRepository->getBrandById($id);
        return view('back/brands/edit')->with(['brand'=>$brand]);
    }

    public function updateBrand(Request $request,$id)
    {
        $result=$this->brandRepository->updateBrand($request,$id);
        return $result;
    }

    public function deleteBrand(Request $request,$id)
    {
        $result=$this->brandRepository->deleteBrand($request,$id);
        return $result;
    }
}
