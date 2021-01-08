<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});

Route::get('products', 'ProductController@index');
Route::group(['prefix' => 'product'], function () {
    Route::post('add', 'ProductController@create');
    Route::get('edit/{id}', 'ProductController@edit');
    Route::post('update/{id}', 'ProductController@update');
    Route::delete('delete/{id}', 'ProductController@destroy');
});

Route::get('categories', 'CategoryController@index');
Route::get('categories/list', 'CategoryController@list');
Route::group(['prefix' => 'category'], function () {
    Route::post('add', 'CategoryController@create');
    Route::get('edit/{id}', 'CategoryController@edit');
    Route::post('update/{id}', 'CategoryController@update');
    Route::delete('delete/{id}', 'CategoryController@destroy');
});