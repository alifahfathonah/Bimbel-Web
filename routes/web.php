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
Route::group(['prefix' => 'tryout'], function () {
    Route::get('/login', 'Tryout\AuthController@loginForm')->name('tryout.login');
    Route::post('/login', 'Tryout\AuthController@login')->name('tryout.post_login');

    Route::group(['middleware' => ['student']], function () {
        Route::get('/dashboard', 'Tryout\TryoutController@dashboard')->name('tryout.dashboard');

        Route::get('/level/{id}', 'Tryout\TryoutController@level_index')->name('tryout.level.index');
        Route::get('/course', 'Tryout\TryoutController@course_index')->name('tryout.course.index');
        Route::get('/mark', 'Tryout\ExamController@mark_question')->name('tryout.exam.mark');
        Route::get('/exam', 'Tryout\ExamController@show_exam')->name('tryout.exam');
        Route::post('/exam', 'Tryout\ExamController@start_exam')->name('tryout.exam.start');
        Route::post('/submit', 'Tryout\ExamController@submit_exam')->name('tryout.exam.submit');

        Route::get('/logout', 'Tryout\AuthController@logout')->name('tryout.logout');
    });
});
