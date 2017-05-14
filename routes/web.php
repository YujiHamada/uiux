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
Route::get('/timeline', 'HomeController@index');
Route::get('/about', 'HomeController@showAbout');
Route::get('/contact', 'HomeController@showContact');
Route::post('/contact', 'HomeController@sendContact');

//ReviewContrller
Route::post('/review/store', 'ReviewController@storeComment');
Route::post('/review/destroy', 'ReviewController@destroyComment');
Route::post('/review/comment/evaluate', 'ReviewController@evaluateComment'); // Ajax

// ReviewPostController
Route::get('/review/create', 'ReviewPostController@create');
Route::get('/post/edit/{review}', 'ReviewPostController@create');
Route::post('/post', 'ReviewPostController@store');
Route::get('/review/{review}', 'ReviewPostController@show');
Route::post('/review/evaluate', 'ReviewPostController@evaluate'); // Ajax
Route::get('/review/delete/{review}', 'ReviewPostController@delete');
Route::get('/review/report/kaizen/{review}', 'ReviewPostController@report');

//ReviewRequestController
Route::get('/request/create', 'ReviewRequestController@create');
Route::get('/review/request/{review}', 'ReviewRequestController@show');
Route::post('/request', 'ReviewRequestController@store');

// UserController
Route::get('/confirm/{token}', 'UserController@getConfirm');
Route::get('/{username}', 'UserController@show');
Route::get('/settings/edit', 'UserController@edit');
Route::post('/settings/edit', 'UserController@store');
Route::get('/settings/link', 'UserController@showLinkSocial');
Route::get('/settings/link/{provider}', 'UserController@unlinkSocial');
Route::post('/settings/crop', 'UserController@crop'); // Ajax

Route::post('/{username}/follow', 'UserController@follow');
Route::get('/{username}/following', 'UserController@showFollowing');
Route::get('/{username}/followers', 'UserController@showFollowers');


//SocialController
Route::get('/login/callback', 'Auth\SocialController@handleError')->name('logincallback');
Route::get('/login/{provider}', 'Auth\SocialController@redirectToSocialAuth');
Route::get('/login/callback/{provider}', 'Auth\SocialController@handleSocialCallback');
Route::post('/register/social', 'Auth\SocialController@create');
