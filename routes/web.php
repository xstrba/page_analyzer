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

Route::get('/', 'IndexController@index')->name('home');

Route::post('/post/headers', 'HeaderController@getHeaders')->name('getHeaders');
Route::post('/post/contents', 'ContentController@getContents')->name('getContents');
Route::post('/post/insights', 'GapiController@getInsights')->name('getInsights');
Route::post('/post/robots', 'RobotController@getRobots')->name('getRobots');
