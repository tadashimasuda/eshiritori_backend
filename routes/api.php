<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/oauth/twitter/redirect','AuthController@redirectToProvider')->middleware('session');
Route::get('/oauth/twitter/callback','AuthController@handleTwwiterCallback');



