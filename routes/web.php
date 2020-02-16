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


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::redirect('/', 'tryout/login', 200);
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::redirect('/', 'admin/dashboard', 301)->name('home');

Route::group(['prefix' => 'tryout'], function () {
    Route::get('/login', 'Tryout\AuthController@loginForm')->name('tryout.login');
    Route::post('/login', 'Tryout\AuthController@login')->name('tryout.post_login');

    Route::group(['middleware' => 'student'], function () {
        Route::get('/dashboard', 'Tryout\TryoutController@dashboard')->name('tryout.dashboard');

        Route::get('/level/{id}', 'Tryout\TryoutController@level_index')->name('tryout.level.index');
        Route::get('/course', 'Tryout\TryoutController@course_index')->name('tryout.course.index');

        Route::get('/profile', 'Tryout\TryoutController@profile')->name('tryout.account.profile');

        Route::get('/mark', 'Tryout\ExamController@mark_question')->name('tryout.exam.mark');
        Route::get('/exam', 'Tryout\ExamController@show_exam')->name('tryout.exam');
        Route::post('/exam', 'Tryout\ExamController@start_exam')->name('tryout.exam.start');
        Route::post('/submit', 'Tryout\ExamController@submit_exam')->name('tryout.exam.submit');

        Route::get('/logout', 'Tryout\AuthController@logout')->name('tryout.logout');
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', 'AuthController@loginForm')->name('login');
        Route::post('/login', 'AuthController@login')->name('login.post');
    });

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/dashboard','FrontController@dashboard')->name('dashboard');
        Route::get('/profile','FrontController@profile')->name('profile');

        Route::get('/settings','SettingController@index')->name('settings.index');

        Route::resource('/teachers', 'TeacherController');
        Route::resource('/students','StudentController');
        Route::resource('/reports', 'ReportController')
        ->except(['create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('/levels', 'LevelController')->only(['store', 'update', 'destroy']);
        Route::resource('/sublevels', 'SublevelController')->only(['store', 'update', 'destroy']);
        Route::resource('/courses', 'CourseController')->only(['store', 'update', 'destroy']);

        Route::group(['prefix' => 'exams', 'as' => 'exams.'], function () {
            Route::get('/','ExamController@index')->name('index');
            Route::get('/{level_id}','ExamController@level_show')->name('level.show');
            Route::get('/{level_id}/create', 'ExamController@sublevel_create')->name('sublevel.create');
            Route::get('/{level_id}/{sublevel_id}/edit', 'ExamController@sublevel_edit')->name('sublevel.edit');
            Route::get('/{level_id}/{sublevel_id}/questions', 'ExamController@manage_question')->name('sublevel.questions');
        });

        Route::get('/logout', 'AuthController@logout')->name('logout');
    });

});
