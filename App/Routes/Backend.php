<?php

use App\Core\Routing\Route;
use App\Middleware\Gate;


/**
 * add middleware example =
 * Route::get('/','exampleController@index',[Gate::class]);
 *
 * adexample =
 * Route::get('/example','exampleController@index');
 * Route::get('/example/example2/{id}','exampleController@index');
 * 
 * 
 * 
 * Route::get('/admin/category', 'CategoryController@index');
 * Route::get('/admin/category/create', 'CategoryController@create');
 * Route::post('/admin/category', 'CategoryController@store');
 * Route::get('/admin/category/{id}', 'CategoryController@show');
 * Route::get('/admin/category/{id}/edit', 'CategoryController@edit');
 * Route::put('/admin/category/{id}', 'CategoryController@update');
 * Route::delete('/admin/category/{id}', 'CategoryController@destroy');
 * 
 * 
 */



Route::group(function () {
    Route::get('/admin/dashboard', 'HomeController@index');
   
});
