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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('check','WebCrawlerController@check');
Route::get('/','WebCrawlerController@index');

Route::any('/load_data','WebCrawlerController@load_data')->name('load_data');
Route::any('/re_load_data','WebCrawlerController@re_load_data')->name('re_load_data');
Route::any('/delete_news','WebCrawlerController@delete_news')->name('delete_news');

