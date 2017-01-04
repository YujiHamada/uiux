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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/post', 'PostController@index');
Route::post('/post/confirmation', 'PostController@postConfirmation');
Route::post('/post/completion', 'PostController@postCompletion');
Route::get('/post/viewPost', 'PostController@viewPost');