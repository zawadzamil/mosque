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

Route::get('/','App\Http\Controllers\DashboardController@home');


Route::get('get-cities', 'App\Http\Controllers\DashboardController@getCities')->name('getCities');
Route::get('get-mosques', 'App\Http\Controllers\DashboardController@getMosque')->name('getMosque');




Route::get('select-mosques','App\Http\Controllers\DashboardController@select');
Route::post('user-select-mosque','App\Http\Controllers\MosqueController@userSelect');

Route::get('add-mosque','App\Http\Controllers\MosqueController@index');
Route::post('addMosquetoDb','App\Http\Controllers\MosqueController@store');
Route::get('show-mosques','App\Http\Controllers\MosqueController@show')->name('show-mosques');
Route::get('view-display','App\Http\Controllers\MosqueController@display');


Route::get('go_back','App\Http\Controllers\MosqueController@back')->name('go_back');



Route::get('add-schedule/{id}','App\Http\Controllers\ScheduleController@index');
Route::post('addSchedule','App\Http\Controllers\ScheduleController@store');
Route::get('show-schedule','App\Http\Controllers\ScheduleController@show')->name('show-schedule');
Route::get('edit-schedule','App\Http\Controllers\ScheduleController@edit');
Route::post('updateSchedule/{id}','App\Http\Controllers\ScheduleController@update');



Route::get('add-notice/{id}','App\Http\Controllers\NoticeController@index');
Route::post('addNotice','App\Http\Controllers\NoticeController@store');
Route::get('show-notice','App\Http\Controllers\NoticeController@show')->name('show-notice');
Route::get('edit-notice/{id}','App\Http\Controllers\NoticeController@edit');
Route::post('updateNotice/{id}','App\Http\Controllers\NoticeController@update');
Route::get('deleteNotice/{id}','App\Http\Controllers\NoticeController@destroy');




Route::get('add-gallery/{id}','App\Http\Controllers\GalleryController@index');
Route::post('addToGallery','App\Http\Controllers\GalleryController@store');
Route::get('show-gallery','App\Http\Controllers\GalleryController@show')->name('show-gallery');
Route::get('removePhoto/{id}','App\Http\Controllers\GalleryController@destroy');




Route::post('logout', 'App\Http\Controllers\LogoutController@logout');


Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
