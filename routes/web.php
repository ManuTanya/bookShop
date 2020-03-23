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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/page','IndexController@myMetod');

Route::get('/','MainController@showMainPage');

Route::get('/admin','MainController@showAdminPage');

Route::get('/api/v1/books/list/{wid}', 'WorkDataController@showWritter');
Route::get('/api/v1/writters/new', 'WorkDataController@newWritter');
Route::get('/api/v1/writters/edit/{wid}', 'WorkDataController@editWritter');
Route::post('/api/v1/writters/save/{wid}', 'WorkDataController@saveDataWritter');
Route::delete('/api/v1/writters/delete/{wid}',  'WorkDataController@deleteWritter');

Route::get('/api/v1/books/by-id/{bid}', 'WorkDataController@showBook');
Route::get('/api/v1/books/new', 'WorkDataController@newBook');
Route::get('/api/v1/books/edit/{bid}', 'WorkDataController@editBook');
Route::post('/api/v1/books/update/{bid}', 'WorkDataController@saveDataBook');
Route::delete('/api/v1/book/{bid}', 'WorkDataController@deleteBook');


