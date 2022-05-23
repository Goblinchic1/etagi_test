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

// GUEST ROUTES
Route::group(['middleware' => 'guest'], function () {
    // REGISTER ROUTES
    Route::get('/register', 'App\Http\Controllers\UserController@create')->name('register.create');
    Route::post('/register', 'App\Http\Controllers\UserController@store')->name('register.store');

    // AUTHORISATION ROUTES
    Route::get('/', 'App\Http\Controllers\UserController@loginForm')->name('login.create');
    Route::post('/login', 'App\Http\Controllers\UserController@login')->name('login');
});

// AUTH ROUTES
route::group(['middleware' => 'auth'], function (){
    Route::get('/logout', 'App\Http\Controllers\UserController@logout')->name('logout');
    Route::get('/dashboard', 'App\Http\Controllers\MainController@index')->name('dashboard');
    Route::resource('/tasks', 'App\Http\Controllers\TaskController');
});
