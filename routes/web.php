<?php

use Illuminate\Support\Facades\Route;

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

// PULIC
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    // DASHBOARD
    Route::get('/home', 'HomeController@index')->name('home');

    // LOANS
    Route::get('/loans', 'LoansController@index')->name('loans');
    Route::get('/loans/create', 'LoansController@create');
    Route::post('/loans', 'LoansController@store');
    Route::put('/loans', 'LoansController@update');

});

