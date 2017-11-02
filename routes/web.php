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

Auth::routes();

Route::group(['middleware' =>'web'], function() {
    Route::match(['get', 'post'],'/', 'HomeController@index')->name('home');
Route::match(['get', 'post'],'/email', 'MailController@email')->name('email');
Route::match(['get', 'post'], '/message/{id}', ['uses'=>'HomeController@index', 'as'=>'message']);
Route::match(['get', 'post'], '/message_detal/{id}', ['uses'=>'HomeController@detals', 'as'=>'message_detal']);
});


