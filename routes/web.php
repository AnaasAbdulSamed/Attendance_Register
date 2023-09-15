<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('admin', function () {
//     return view('admin');
//  });

Route::get('/admin', 'HomeController@adminHome')->name('admin');
Route::get('/superadmin', 'HomeController@superadminHome')->name('superadmin');
Route::post('dateTime', 'HomeController@dateTime')->name('dateTime');
Route::post('endTime', 'HomeController@endTime')->name('endTime');


Route::post('/submitAttendance', 'HomeController@storeAttendance');
