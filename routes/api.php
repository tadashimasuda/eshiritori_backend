<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/oauth/twitter/redirect','AuthController@redirectToProvider')->middleware('session');
Route::get('/oauth/twitter/callback','AuthController@handleTwitterCallback');

Route::group(['prefix'=>'user'],function(){

    //create user mail
    Route::post('/','AuthController@store');
   
    Route::middleware('auth:api')->get('/followers','AuthController@followers');
    Route::middleware('auth:api')->get('/','AuthController@user');
    Route::middleware('auth:api')->put('/update','AuthController@update');
});

Route::get('/users/{id}','AuthController@show');
Route::get('/users','AuthController@index');

Route::group(['prefix'=>'tables'],function(){
    Route::middleware('auth:api')->post('/','TableController@store');
    Route::get('/{id}/post','PostController@LatestFirstTablePost');
    Route::get('/{id}/user','TableController@user');
    Route::get('/{id}','TableController@show');
    Route::get('/','TableController@index');
    Route::middleware('auth:api')->put('/{id}/update','TableController@update');
});

Route::group(['prefix'=>'posts'],function(){
    Route::middleware('auth:api')->post('/','PostController@store');
    Route::get('/','PostController@index');
    Route::get('/{id}','PostController@show');
});