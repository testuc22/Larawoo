<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->namespace('Back')->group(function(){
	Route::name('alogin')->get('login', [App\Http\Controllers\Back\AdminController::class,'getAdminLoginPage']);
	Route::name('trylogin')->post('trylogin', [App\Http\Controllers\Back\AdminController::class,'doAdminLogin']);
	Route::middleware('admin')->group(function(){
		Route::name('adminlogout')->get('adminlogout', [App\Http\Controllers\Back\AdminController::class,'doAdminLogout']);
		Route::name('dashboard')->get('admindashboard', [App\Http\Controllers\Back\AdminController::class,'getAdminHomePage']);

		/* Category Pages */

	 	Route::name('listcategories')->get('listcategories', [App\Http\Controllers\Back\CategoryController::class,'getAllCategories']);
	 	Route::name('addcategory')->get('addcategory', [App\Http\Controllers\Back\CategoryController::class,'getCreateCategoryPage']);
	 	Route::name('createcategory')->post('createcategory', [App\Http\Controllers\Back\CategoryController::class,'createNewCategory']);
	 	Route::name('editcategory')->get('editcategory/{id}', [App\Http\Controllers\Back\CategoryController::class,'getEditCategoryPage']);
	 	Route::name('updatecategory')->put('updatecategory/{id}', [App\Http\Controllers\Back\CategoryController::class,'updateCategory']);

	 	/* Attribute Pages */

	 	Route::name('listattributes')->get('listattributes', [App\Http\Controllers\Back\AttributeController::class,'getAllAttributes']);
	 	Route::name('addattribute')->get('addattribute', [App\Http\Controllers\Back\AttributeController::class,'getCreateAttributePage']);
	 	Route::name('createattribute')->post('createattribute', [App\Http\Controllers\Back\AttributeController::class,'createNewAttribute']);
	 	Route::name('editattribute')->get('editattribute/{id}', [App\Http\Controllers\Back\AttributeController::class,'getEditAttributePage']);
	 	Route::name('updateattribute')->put('updateattribute/{id}', [App\Http\Controllers\Back\AttributeController::class,'updateAttribute']);
	 	Route::name('deleteattribute')->delete('deleteattribute/{id}', [App\Http\Controllers\Back\AttributeController::class,'deleteAttribute']);

	 	/* Attribute Values Pages */

	 	Route::name('showattributevalues')->get('showattributevalues/{id}', [App\Http\Controllers\Back\AttributeController::class,'getAllAttributeValuesById']);
	 	Route::name('addattributevalue')->get('addattributevalue/{id}', [App\Http\Controllers\Back\AttributeController::class,'getCreateAttributeValuePage']);
	 	Route::name('createattributevalue')->post('createattributevalue', [App\Http\Controllers\Back\AttributeController::class,'createNewAttributeValue']);
	 	Route::name('editattributevalue')->get('editattributevalue/{id}/{atrid}', [App\Http\Controllers\Back\AttributeController::class,'getEditAttributeValuePage']);
	 	Route::name('updateattributevalue')->put('updateattributevalue/{id}', [App\Http\Controllers\Back\AttributeController::class,'updateAttributeValue']);
	 	Route::name('deleteattributevalue')->delete('deleteattributevalue/{id}/{atrid}', [App\Http\Controllers\Back\AttributeController::class,'deleteAttributeValue']);

	 	/* Brands Pages */

	 	Route::name('listbrands')->get('listbrands', [App\Http\Controllers\Back\BrandController::class,'getAllBrands']);
	 	Route::name('addbrand')->get('addbrand', [App\Http\Controllers\Back\BrandController::class,'getCreateBrandPage']);
	 	Route::name('createbrand')->post('createbrand', [App\Http\Controllers\Back\BrandController::class,'createBrand']);
	 	Route::name('editbrand')->get('editbrand/{id}', [App\Http\Controllers\Back\BrandController::class,'getEditBrandPage']);
	 	Route::name('updatebrand')->put('updatebrand/{id}', [App\Http\Controllers\Back\BrandController::class,'updateBrand']);
	 	Route::name('deletebrand')->delete('deletebrand/{id}', [App\Http\Controllers\Back\BrandController::class,'deleteBrand']);

	 	/* Tag Pages */

	 	Route::name('listtags')->get('listtags', [App\Http\Controllers\Back\TagController::class,'getAllTags']);
	 	Route::name('addtag')->get('addtag', [App\Http\Controllers\Back\TagController::class,'getCreateTagPage']);
	 	Route::name('createtag')->post('createtag', [App\Http\Controllers\Back\TagController::class,'createTag']);
	 	Route::name('edittag')->get('edittag/{id}', [App\Http\Controllers\Back\TagController::class,'getEditTagPage']);
	 	Route::name('updatetag')->put('updatetag/{id}', [App\Http\Controllers\Back\TagController::class,'updateTag']);
	 	Route::name('deletetag')->delete('deletetag/{id}', [App\Http\Controllers\Back\TagController::class,'deleteTag']);

	 	/* Product Pages */

	 	Route::name('listproducts')->get('listproducts', [App\Http\Controllers\Back\ProductController::class,'getAllProducts']);
	 	Route::name('addproduct')->get('addproduct', [App\Http\Controllers\Back\ProductController::class,'getCreateProductPage']);
	 	Route::name('createproduct')->post('createproduct', [App\Http\Controllers\Back\ProductController::class,'createProduct']);
	 	Route::name('editproduct')->get('editproduct/{id}', [App\Http\Controllers\Back\ProductController::class,'getEditProductPage']);
	 	Route::name('updateproduct')->put('updateproduct/{id}/{tab?}', [App\Http\Controllers\Back\ProductController::class,'updateProduct']);
	 	Route::name('upload-product-images')->post('upload-product-images/{id}', [App\Http\Controllers\Back\ProductController::class,'uploadProductImages']);
	 	Route::name('delete-product-image')->get('delete-product-image', [App\Http\Controllers\Back\ProductController::class,'deleteProductImage']);
	 	Route::name('assign-product-tags')->post('assign-product-tags/{id}', [App\Http\Controllers\Back\ProductController::class,'assignTagsToProduct']);
	 	Route::name('generate-product-combinations')->post('generate-product-combinations/{id}', [App\Http\Controllers\Back\ProductController::class,'generateProductCombinations']);

	});
});
