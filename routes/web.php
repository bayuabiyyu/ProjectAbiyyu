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
    return redirect('/form');
});


//Form Crud
Route::get('/data', 'FormController@data');
Route::get('/datatable', 'FormController@dataTable');
Route::get('/form', 'FormController@index');
Route::get('/form/create', 'FormController@create');
Route::post('/form', 'FormController@store');
Route::get('/form/{id}', 'FormController@show');
Route::get('/form/edit/{id}', 'FormController@edit');
Route::post('/form/update/{id}', 'FormController@update');
Route::post('/form/destroy/{id}', 'FormController@destroy');
