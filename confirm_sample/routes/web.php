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

Route::get('/form', 'SampleFormController@show')->name('form.show');
Route::post('/form', "SampleFormController@post")->name("form.post");

Route::get('/form/confirm', "SampleFormController@confirm")->name("form.confirm");
Route::post('/form/confirm', "SampleFormController@send")->name("form.send");

Route::get('/form/thanks', "SampleFormController@complete")->name("form.complete");
