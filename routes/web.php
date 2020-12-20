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
    return view('index');
});

Auth::routes();

Route::get('/admin', 'AdminController@index');
Route::get('/map', 'AdminController@map');
Route::get('/customers', 'AdminController@customers');
Route::post('/status/{id}', 'AdminController@statusupdate');



Route::get('/home', 'HomeController@index')->name('home');

Route::resource('bursts', 'BurstController');

Route::get('/customer/print-pdf', 'CustomerController@printPDF')->name('report');
