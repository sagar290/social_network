<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home
Route::get('/', [
    'uses' => '\blog\Http\Controllers\HomeController@index',
    'as' => 'home',
]);

// Authentication

    
Route::get('/signup', [
    'uses' => '\blog\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup',
    'middleware' => ['guest'],
]);

Route::post('/signup', [
    'uses' => '\blog\Http\Controllers\AuthController@postSignup'

]);

Route::get('/signin', [
    'uses' => '\blog\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest'],
]);

Route::post('/signin', [
    'uses' => '\blog\Http\Controllers\AuthController@postSignin'

]);

Route::get('/signout', [
    'uses' => '\blog\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout',
]);

// Search
Route::get('/search', [
    'uses' => '\blog\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);

// User
Route::get('/user/{username}', [
    'uses' => '\blog\Http\Controllers\profileController@getProfile',
    'as' => 'profile.index',
]);

Route::get('/profile/edit', [
    'uses' => '\blog\Http\Controllers\profileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'],
]);
Route::post('/profile/edit', [
    'uses' => '\blog\Http\Controllers\profileController@postEdit',
    'middleware' => ['auth']
]);


/**
* friends
*
*/
Route::get('/friends', [
    'uses' => '\blog\Http\Controllers\friendsController@getIndex',
    'as' => 'friend.index',
    'middleware' => ['auth'],
]);

Route::get('/friends/add/{username}', [
    'uses' => '\blog\Http\Controllers\friendsController@getAdd',
    'as' => 'friend.add',
    'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
    'uses' => '\blog\Http\Controllers\friendsController@getAccept',
    'as' => 'friend.accept',
    'middleware' => ['auth'],
]);

//statuses

Route::post('/status', [
    'uses' => '\blog\Http\Controllers\StatusesController@postStatus',
    'as' => 'status.post',
    'middleware' => ['auth'],
]);


Route::post('/status/{statusId}/reply', [
    'uses' => '\blog\Http\Controllers\StatusesController@postReply',
    'as' => 'status.reply',
    'middleware' => ['auth'],
]);


Route::get('/status/{statusId}/like', [
    'uses' => '\blog\Http\Controllers\StatusesController@getLike',
    'as' => 'status.like',
    'middleware' => ['auth'],
]);






























