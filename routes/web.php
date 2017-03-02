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
Route::post('/review/agree', 'ReviewController@agree');

// UserController
Route::get('/{username}', 'UserController@show');
Route::get('/settings/edit', 'UserController@edit');
Route::post('/settings/edit', 'UserController@confirm');
Route::post('/settings/crop', 'UserController@crop');


//SocialController
Route::get('/login/twitter', 'Auth\SocialController@getTwitterAuth');
Route::get('/login/callback/twitter', 'Auth\SocialController@getTwitterAuthCallback');
Route::post('/register/social', 'Auth\SocialController@register');
