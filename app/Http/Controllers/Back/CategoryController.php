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
        return $categories;
    	return view('back/categories/create')->with('categories',$categories);
    }

    public function createNewCategory(Request $request)
    {
        $result=$this->categoryRepository->createNewCategory($request);
        return $result;
    }
}
