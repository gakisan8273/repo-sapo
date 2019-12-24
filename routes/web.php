<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/make', 'TweetController@index')->name('make');
Route::get('/login', 'TweetController@login')->name('login');
Route::get('/format', 'TweetController@format')->name('format');
Route::get('/calcday', 'TweetController@calcday')->name('calcday');