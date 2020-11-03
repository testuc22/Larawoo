<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Str;
/**
 * Category Class
 */
class CategoryRepository
{
	protected $categories=[];

	public function getAllCategories()
	{
	    return Category::all();
	}

	public function getParentCatogiesOnly()
	{
	    return Category::where('parentId','=','0')->get();
	}

	public function getCategoriesTree()
	{
	    // $parentCategories=$this->getParentCategories();
	    $allCategories=$this->getAllCategories();
	    // dd($allCategories);
	    $categoryList=[];
	    foreach($allCategories as $category){
	    	/*$categoryList[$category->id]=$category->title;
	    	$categoryList[]=$this->getParentCategories($category->id);*/

	    	if ($category->parentId==0) {
	    		$categoryList[]=array('id'=>$category->id,'title'=>$category->title);
	    	}
	    	else {
	    		$temp=$this->getParentCategories($category->parentId);
	    		// echo $category->id;
	    		dump($temp);
	    		$categoryList[]=array('id'=>$category->id,'title'=>$category->title);
	    	}
	    }
	    return $categoryList;
	}

	public function getParentCategories($id,$categoryList=[])
	{
		$categories=Category::where('id','=',$id)->get();
		// dd($categories);
		foreach ($categories as $category) {
		    if ($category->parentId==0) {
	    		$categoryList[]=$category->title;
	    	}
	    	else {
	    		$categoryList[]=$category->title;
	    		$temp=$this->getParentCategories($category->parentId,$categoryList);
	    		$categoryList[]=$temp;
	    	}
		}
		// print_r($categoryList);die;
		// dd($category[0]->title);
		// dump($category);
		/*if(count($category)) {
			$this->categories[$category[0]->id]=$category[0]->title;
			$this->getParentCategories($category[0]->id);
		}*/
		// $this->categories[]=$category;
		// $cat=$this->categories;
		// $this->categories=[];
		return $categoryList;
	}

	public function createNewCategory($request)
	{
	    $request->validate([
	    	'title'=>'required',
	    	'meta_title'=>'required',
	    	'description'=>'required'
	    ]);

	    Category::create([
	    	'title'=>$request->title,
	    	'slug'=>Str::slug($request->title,'-'),
	    	'parentId'=>$request->parent_category,
	    	'metaTitle'=>$request->meta_title,
	    	'content'=>$request->description,
	    ]);
	    $request->session()->flash('success','Category Created Successfully');
	    return redirect()->route('listcategories');
	}
}