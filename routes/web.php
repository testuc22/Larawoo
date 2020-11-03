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
	});
});
