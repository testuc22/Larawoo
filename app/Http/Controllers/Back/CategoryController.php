<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
class CategoryController extends Controller
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository=$categoryRepository;
    }

    public function getAllCategories()
    {
    	$categories=$this->categoryRepository->getAllCategories();
    	return view('back/categories/list')->with('categories',$categories);
    }

    public function getCreateCategoryPage()
    {
        $categories=$this->categoryRepository->getCategoriesTree();
        // return $categories;
    	return view('back/categories/create')->with('categories',$categories);
    }

    public function createNewCategory(Request $request)
    {
        $result=$this->categoryRepository->createNewCategory($request);
        return $result;
    }

    public function getEditCategoryPage(Request $request,$id)
    {
    	$category=$this->categoryRepository->getOneCategory($id);
    	$categories=$this->categoryRepository->getCategoriesTree();
    	// return $categories;
    	$parentCategory=array_values(array_filter($categories,function($p_category) use ($category){
          return $category->parentId==$p_category['id'];
        }));
        $parentFound['id']=count($parentCategory) > 0 ? $parentCategory[0]['id'] : array();
    	return view('back/categories/edit')->with(['categories'=>$categories,'category'=>$category,'parentExist'=>$parentFound]);
    }

    public function updateCategory(Request $request,$id)
    {
        $result=$this->categoryRepository->updateCategory($request,$id);
        return $result;
    }
}
