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

	/*public function getCategoriesTree()
	{   
		$catList=array();
	    $parentCategories=$this->getParentCatogiesOnly();
	    $categoryList=[];
	    foreach($parentCategories as $category){
	        $catList[$category->id]=$category->toArray();
	        $catList[$category->id]['childs']=array();
	    }

	    foreach($catList as $parentId=>$cat){
            $this->getChildByParentId($parentId,$catList[$parentId]['childs']); 
	    }
	    dump($catList);

	    return $categoryList;
	}*/

	public function getCategoriesTree()
	{
		$catList=array();
		$allCategories=$this->getAllCategories();
		foreach($allCategories as $category){
			$catList[$category->id]=array('id'=>$category->id,'title'=>$category->title,'parent'=>$category->parentId);
			if ($category->parentId!=0) {
	    		$catList[$category->id]['childs']=array();
	    		$this->getParentCategories($category->parentId,$catList[$category->id]['childs']);
	    	}
	    	// dd($catList);
		}
		// dump( $catList);
		return $catList;
	}

	public function getChildByParentId($id,&$childs){

        $categories=Category::where('parentId','=',$id)->get();
        
        foreach ($categories as $category) {
        	if(!isset($childs[$category->id]['childs'])){
        		 $childs[$category->id]=$category->toArray();
                 $childs[$category->id]['childs']=array();
        	}
           $this->getChildByParentId($category->id,$childs[$category->id]['childs']);
        }
       
	}

	public function getParentCategories($id,&$categoryList)
	{
		$category=Category::where('id','=',$id)->first();
		// dump($categoryList);
			$categoryList[]=array('id'=>$category->id,'title'=>$category->title);
		    if ($category->parentId!=0) {
	    		$this->getParentCategories($category->parentId,$categoryList);
	    	}
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

	public function getOneCategory($id)
	{
	    return Category::find($id);
	}

	public function updateCategory($request,$id)
	{
	    $request->validate([
	    	'category_name'=>'required',
	    	'meta_title'=>'required',
	    	'description'=>'required'
	    ]);

	    $category=$this->getOneCategory($id);
	    $category->title=$request->category_name;
	    $category->slug=Str::slug($request->category_name,'-');
	    $category->parentId=$request->parent_category;
	    $category->metaTitle=$request->meta_title;
	    $category->content=$request->description;
	    $category->save();
	    $request->session()->flash('success','Category Updated Successfully');
	    return redirect()->route('listcategories');
	}

	public function deleteCategory($request,$id)
	{
	    $category=$this->getOneCategory($id);
	    $category->delete();
	    $request->session()->flash('success','Category Deleted Successfully');
	    return redirect()->route('listcategories');
	}
}