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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'tryout'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', 'Tryout\AuthController@loginForm')->name('tryout.login');
        Route::post('/login', 'Tryout\AuthController@login')->name('tryout.post_login');
    });

    Route::group(['middleware' => ['student']], function () {
        Route::view('/dashboard', 'tryout\dashboard')->name('tryout.dashboard');
        Route::get('/logout', 'Tryout\AuthController@logout')->name('tryout.logout');
    });
});
