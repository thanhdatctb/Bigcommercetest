<?php

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

Route::get('/', "BigcommerceController@index");
Route::group(['middleware' => ['web']], function () {
	Route::group(['prefix'=>'/auth'],function (){
		Route::get('/install',"BigcommerceController@install");
		Route::get("/load","BigcommerceController@load")->name("load");
		Route::get("/uninstall","BigcommerceController@uninstall");
	});
    Route::get("/delete/{id}","ProductController@deleteById");
	Route::get("/edit/{id}","ProductController@prepareForUpdate");
	Route::post("/edit/{id}","ProductController@updateProduct");

});



