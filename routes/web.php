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
    return view('view');
});


Route::get('/carros/{id?}','Carro@get');

Route::post('/carros','Carro@add');

Route::patch('/carros', 'Carro@update');

Route::delete('/carros/{id}','Carro@delete');

