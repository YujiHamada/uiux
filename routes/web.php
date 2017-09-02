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
Route::get( '/', 'HomeController@index');
Route::get( '/timeline', 'HomeController@index');
Route::get( '/about', 'HomeController@showAbout');
Route::get( '/contact', 'HomeController@showContact');
Route::post('/contact', 'HomeController@sendContact');
Route::get( '/legal', 'HomeController@showLegal');
Route::get( '/privacy', 'HomeController@showPrivacy');
<<<<<<< HEAD
Route::post('/settings/crop', 'HomeController@crop'); // Ajax
=======
Route::post( '/notification/read', 'HomeController@notificationReadAt');
>>>>>>> master

//ReviewContrller
Route::get( '/review/delete/{review}', 'ReviewController@delete');
Route::post('/review/comment/store', 'ReviewController@storeComment');
Route::post('/review/comment/delete', 'ReviewController@deleteComment');
Route::post('/review/evaluate', 'ReviewController@evaluateReview'); // Ajax
Route::post('/review/comment/evaluate', 'ReviewController@evaluateComment'); // Ajax

// ReviewPostController
Route::get( '/post/create', 'ReviewPostController@create');
Route::get( '/post/edit/{review}', 'ReviewPostController@create');
Route::get( '/post/{review}', 'ReviewPostController@show');
Route::post('/post/store', 'ReviewPostController@store');
Route::get( '/post/report/kaizen/{review}', 'ReviewPostController@report');

//ReviewRequestController
Route::get( '/request/create', 'ReviewRequestController@create');
Route::get( '/request/edit/{review}', 'ReviewRequestController@create');
Route::get( '/request/{review}', 'ReviewRequestController@show');
Route::post('/request/store', 'ReviewRequestController@store');

// UserController
Route::get( '/confirm/{token}', 'UserController@getConfirm');
Route::get( '/{username}', 'UserController@show');
Route::get( '/settings/edit', 'UserController@edit');
Route::post('/settings/edit', 'UserController@store');
Route::get( '/settings/password', 'UserController@resetPassword');
Route::get( '/settings/link', 'UserController@showLinkSocial');
Route::get( '/settings/link/{provider}', 'UserController@unlinkSocial');


Route::post('/{username}/follow', 'UserController@follow');
Route::get( '/{username}/following', 'UserController@showFollowing');
Route::get( '/{username}/followers', 'UserController@showFollowers');
Route::get( '/{username}/leave', 'UserController@leave');
Route::post( '/left', 'UserController@left');


//SocialController
Route::get( '/login/callback', 'Auth\SocialController@handleError')->name('logincallback');
Route::get( '/login/{provider}', 'Auth\SocialController@redirectToSocialAuth');
Route::get( '/login/callback/{provider}', 'Auth\SocialController@handleSocialCallback');
Route::post('/register/social', 'Auth\SocialController@create');
