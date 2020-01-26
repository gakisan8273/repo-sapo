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

Route::get('/', 'Auth\TwitterController@index')->name('make');
Route::get('/business', 'Auth\TwitterController@business');
Route::post('/post-format', 'Auth\TwitterController@editFormat')->name('post-format');
Route::post('/post-business-format', 'Auth\TwitterController@editBusinessFormat');
Route::post('/post-calcday', 'Auth\TwitterController@editCalcday')->name('post-calcday');
Route::get('/login', 'Auth\TwitterController@login')->name('login');
Route::get('/format', 'Auth\TwitterController@format')->name('format');
Route::get('/business-format', 'Auth\TwitterController@businessFormat');
Route::get('/calcday', 'Auth\TwitterController@calcday')->name('calcday');
Route::get('/readme', 'Auth\TwitterController@readme')->name('readme');
Route::get('/select', 'Auth\TwitterController@select');

//ログインURL
Route::get('/auth/twitter', 'Auth\TwitterController@redirectToProvider');
// コールバックURL
Route::get('/auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
// ログアウトURL
Route::get('/auth/twitter/logout', 'Auth\TwitterController@logout');

// Laravel x S3 練習用
Route::post('/upload', 'Auth\TwitterController@upload');
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
