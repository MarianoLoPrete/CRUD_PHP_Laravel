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
// Route::get('/empleados', 'EmpleadosController@index');
// Route::get('/empleados/create','EmpleadosController@create');




Route::get('/', function () {
    return view('auth.login');
});

Route::resource('empleados', 'EmpleadosController')->middleware(('auth'));

Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

