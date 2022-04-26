<?php

use App\Core\Routing\Route;
use App\Middleware\Gate;


/**
 * add middleware example =
 * Route::get('/','exampleController@index',[Gate::class]);
 *
 * add slug example =
 * Route::get('/example/{slug}','exampleController@index');
 * Route::get('/example/{slug}/example2/{id}','exampleController@index');
 * 
 * Route::get('/category', 'CategoryController@index');
 * Route::get('/category/create', 'CategoryController@create');
 * Route::post('/category', 'CategoryController@store');
 * Route::get('/category/{id}', 'CategoryController@show');
 * Route::get('/category/{id}/edit', 'CategoryController@edit');
 * Route::put('/category/{id}', 'CategoryController@update');
 * Route::delete('/category/{id}', 'CategoryController@destroy');
 *
 */

Route::group(function () {

    Route::get('/', 'HomeController@index');
});
