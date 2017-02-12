<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

// HomeController
Route::get('/', 'HomeController@index');

// ReviewController
Route::get('/review/create', 'ReviewController@create');
Route::post('/review/create', 'ReviewController@confirm');
Route::post('/review', 'ReviewController@store');
Route::get('/review/{review}', 'ReviewController@show');

// UserController
Route::get('/{username}', 'UserController@show');
Route::get('/{username}/edit', 'UserController@edit');
Route::post('/{username}/edit', 'UserController@confirm');
