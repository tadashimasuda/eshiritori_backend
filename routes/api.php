<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/oauth/twitter/redirect','AuthController@redirectToProvider')->middleware('session');
Route::get('/oauth/twitter/callback','AuthController@handleTwitterCallback');
Route::middleware('auth:api')->get('/user/followers','AuthController@followers');
Route::middleware('auth:api')->get('/user','AuthController@user');
Route::get('/users/{id}','AuthController@show');
Route::get('/users','AuthController@index');

Route::middleware('auth:api')->put('/user/update','AuthController@update');

Route::middleware('auth:api')->post('/table','TableController@store');
Route::middleware('auth:api')->get('/tables/{id}/post','PostController@show');
Route::get('/tables/{id}','TableController@show');
Route::get('/tables','TableController@index');
Route::middleware('auth:api')->put('/table/{id}/update','TableController@update');

Route::middleware('auth:api')->post('/post','PostController@store');
Route::get('/posts','PostController@index');
Route::get('/posts/{id}','PostController@show');


