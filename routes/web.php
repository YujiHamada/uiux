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
Route::get('/review', 'ReviewController@index');
Route::post('/review/confirmation', 'ReviewController@reviewConfirmation');
Route::post('/review/completion', 'ReviewController@reviewCompletion');
Route::get('/review/viewReview', 'ReviewController@viewReview');