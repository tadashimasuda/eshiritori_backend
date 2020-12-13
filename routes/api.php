<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/oauth/twitter/redirect','AuthController@redirectToProvider')->middleware('session');
Route::get('/oauth/twitter/callback','AuthController@handleTwwiterCallback');
// Route::get('/user','AuthController@user');
Route::middleware('auth:api')->get('/user','AuthController@user');
Route::middleware('auth:api')->put('/user/update','AuthController@update');

