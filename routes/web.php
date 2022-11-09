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

Route::get('/', function () {
    return view('index');
});

Route::get('/punch', 'App\Http\Controllers\PunchController@index')->name('punch');
Route::get('/punch/{id}', 'App\Http\Controllers\PunchController@user_punch');
Route::middleware('checkIp')->post('/punch/start_work/', 'App\Http\Controllers\PunchController@start');
Route::middleware('checkIp')->post('/punch/stop_work/', 'App\Http\Controllers\PunchController@stop');
Route::post('/punch/ajax_update', 'App\Http\Controllers\PunchController@ajaxUpdate');

Route::get('/quote/{id}', 'App\Http\Controllers\QuoteController@index');
Route::post('/quote/{id}', 'App\Http\Controllers\QuoteController@count');

Route::get('excel/export/punch/{id}/{year}-{month}','ExcelController@punchExport');

Route::post('/login', 'UserController@login')->name('login');
