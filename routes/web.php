<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes HOOOO HAHAHAHAHA HOOOOO HAHAHAHAHA 
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
		Route::name('listusers')->get('listusers', [App\Http\Controllers\Back\AdminController::class,'getListUserPage']);
		Route::name('login-user-by-admin')->get('login-user-by-admin/{id}', [App\Http\Controllers\Back\AdminController::class,'loginUserByAdmin']);

		/* Category Pages */

	 	Route::name('listcategories')->get('listcategories', [App\Http\Controllers\Back\CategoryController::class,'getAllCategories']);
	 	Route::name('addcategory')->get('addcategory', [App\Http\Controllers\Back\CategoryController::class,'getCreateCategoryPage']);
	 	Route::name('createcategory')->post('createcategory', [App\Http\Controllers\Back\CategoryController::class,'createNewCategory']);
	 	Route::name('editcategory')->get('editcategory/{id}', [App\Http\Controllers\Back\CategoryController::class,'getEditCategoryPage']);
	 	Route::name('updatecategory')->put('updatecategory/{id}', [App\Http\Controllers\Back\CategoryController::class,'updateCategory']);
	 	Route::name('deletecategory')->delete('deletecategory/{id}', [App\Http\Controllers\Back\CategoryController::class,'deleteCategory']);
	 	Route::name('show-category-in-menu')->put('show-category-in-menu', [App\Http\Controllers\Back\CategoryController::class,'showHideCategoryInMenu']);

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
	 	Route::name('update-variant-images')->post('update-variant-images', [App\Http\Controllers\Back\ProductController::class,'updateVariantImages']);
	 	Route::name('delete-product-variant')->post('delete-product-variant', [App\Http\Controllers\Back\ProductController::class,'deleteProductVariant']);
	 	Route::name('update-variant-details')->post('update-variant-details', [App\Http\Controllers\Back\ProductController::class,'updateProductVariant']);
	 	Route::name('update-product-combinations-images')->get('update-product-combinations-images/{id}', [App\Http\Controllers\Back\ProductController::class,'refreshProductVariantImages']);

	 	/*-----Order Pages------*/

	 	Route::name('listorders')->get('listorders', [App\Http\Controllers\Back\OrderController::class,'getAllOrders']);
	 	Route::name('order-details')->get('order-details/{id}', [App\Http\Controllers\Back\OrderController::class,'getOrderDetails']);
	 	Route::name('change-order-status')->put('change-order-status/{id}', [App\Http\Controllers\Back\OrderController::class,'changeOrderStatus']);

	});
});

/*-----------Front End Routes------------*/

Route::namespace('Front')->group(function(){
	Route::name('home')->get('/', [App\Http\Controllers\Front\HomeController::class,'getHomePage']);
	Route::name('products')->get('products/{slug}', [App\Http\Controllers\Front\ProductController::class,'getProductList']);
	Route::name('filter-products')->post('filter-products', [App\Http\Controllers\Front\ProductController::class,'filterProductList']);
	Route::name('single-product')->get('single-product/{id}/{variant?}', [App\Http\Controllers\Front\ProductController::class,'getSingleProductPage']);
	Route::name('get-product-variant')->post('get-product-variant/{id}', [App\Http\Controllers\Front\ProductController::class,'getProductVariant']);
	Route::name('add-to-cart')->post('add-to-cart', [App\Http\Controllers\Front\ProductController::class,'addProductToCart']);
	Route::name('user-cart')->get('user-cart', [App\Http\Controllers\Front\ProductController::class,'getUserCartPage']);
	Route::name('update-cart')->put('update-cart', [App\Http\Controllers\Front\ProductController::class,'updateUserCart']);
	Route::name('remove-cart-item')->delete('remove-cart-item', [App\Http\Controllers\Front\ProductController::class,'removeCartItem']);
	Route::name('checkout')->get('checkout', [App\Http\Controllers\Front\ProductController::class,'getCheckOutPage']);
	/*--------User Pages--------*/
	Route::name('register-user')->post('register-user', [App\Http\Controllers\Front\UserController::class,'registerUser']);
	Route::name('userlogin')->post('userlogin', [App\Http\Controllers\Front\UserController::class,'userLogin']);
	Route::name('userlogout')->post('userlogout', [App\Http\Controllers\Front\UserController::class,'userLogOut']);
	Route::name('my-account')->get('my-account', [App\Http\Controllers\Front\UserController::class,'getMyAccountPage']);
	Route::name('getaddress')->get('getaddress', [App\Http\Controllers\Front\UserController::class,'getMyAddressesPage']);
	Route::name('save-address')->post('save-address', [App\Http\Controllers\Front\UserController::class,'saveUserAddress']);
	Route::name('save-order')->post('save-order', [App\Http\Controllers\Front\UserController::class,'createNewOrder']);
});
