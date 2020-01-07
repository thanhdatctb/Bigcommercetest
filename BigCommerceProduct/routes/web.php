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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'/auth'],function (){
  Route::get('/install',"BigcommerceController@install");
  Route::get("/load","BigcommerceController@load");
  Route::get("/uninstall","BigcommerceController@uninstall");


});
Route::get("/orders","BigcommerceController@getAllOrder");

//---------------------


