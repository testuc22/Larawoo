<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandRepository
{
	
	public function getAllBrands()
	{
	    return Brand::all();
	}

	public function createBrand($request)
	{
	    $request->validate([
	    	'brand_name'=>'required'
	    ]);
	    Brand::create([
	    	'brandName'=>$request->brand_name
	    ]);
	    $request->session()->flash('success','Brand Created Successfully');
	    return redirect()->route('listbrands');
	}

	public function getBrandById($id)
	{
	    return Brand::find($id);
	}

	public function updateBrand($request,$id)
	{
	    $request->validate([
	    	'brand_name'=>'required'
	    ]);

	    $brand=$this->getBrandById($id);
	    $brand->brandName=$request->brand_name;
	    $brand->save();
	    $request->session()->flash('success','Brand Updated Successfully');
	    return redirect()->route('listbrands');
	}

	public function deleteBrand($request,$id)
	{
	    $brand=$this->getBrandById($id);
	    $brand->delete();
	    $request->session()->flash('success','Brand Deleted Successfully');
	    return redirect()->route('listbrands');
	}
}