<?php

use App\Http\Controllers\Admin\QuestionController;
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

// Student Routes
Route::group(['prefix' => 'tryout', 'as' => 'tryout.'], function () {

    // Login
    Route::get('/login', 'Tryout\AuthController@loginForm')->name('login');
    Route::post('/login', 'Tryout\AuthController@login')->name('login.post');

    // Student Dashboard
    Route::group(['middleware' => 'student'], function () {
        Route::get('/dashboard', 'Tryout\TryoutController@dashboard')->name('dashboard');
        Route::get('/profile', 'Tryout\TryoutController@profile')->name('profile');
        Route::put('/profile', 'Tryout\TryoutController@edit_profile')->name('profile.edit_profile');
        Route::post('/profile/change_password', 'Tryout\TryoutController@change_password')->name('profile.change_password');
        Route::get('/logout', 'Tryout\AuthController@logout')->name('logout');

        // Exams
        Route::group(['as' => 'exams.'], function () {
            //Exams API
            Route::get('/exam/prepare', 'Api\Tryout\ExamController@prepare')->name('prepare');
            Route::get('/exam/mark', 'Api\Tryout\ExamController@mark')->name('mark');
            Route::get('/exam/answer', 'Api\Tryout\ExamController@answer')->name('answer');
            Route::post('/exam/submit', 'Api\Tryout\ExamController@submit')->name('submit');


            Route::get('/exam', 'Tryout\ExamController@index')->name('index');
            Route::get('/exam/run', 'Tryout\ExamController@run')->name('run');
            Route::get('/exam/{level_id}', 'Tryout\ExamController@show')->name('show');
            Route::post('/exam/{level_id}/{sublevel_id}', 'Tryout\ExamController@start')->name('start');

        });

    });
});


// Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // Login
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', 'Admin\AuthController@loginForm')->name('login');
        Route::post('/login', 'Admin\AuthController@login')->name('login.post');
    });

    // Manage Questions API
    Route::get('/questions/{sublevel_id}', 'Admin\QuestionController@index')->name('questions.index');
    Route::resource('/questions', 'Admin\QuestionController')->except(['index', 'edit', 'create']);

    // Admin Dashboard
    Route::group(['middleware' => 'auth'], function () {

        //Dashboard
        Route::get('/dashboard','Admin\FrontController@dashboard')->name('dashboard');
        Route::get('/profile','Admin\FrontController@profile')->name('profile');

        // Settings
        Route::get('/settings','Admin\SettingController@index')->name('settings.index');

        // Manage Resources
        Route::resource('/teachers', 'Admin\TeacherController');
        Route::resource('/students','Admin\StudentController');
        Route::resource('/reports', 'Admin\ReportController')->only(['index', 'show']);

        // Manage Exams
        Route::resource('/levels', 'Admin\LevelController')->only(['store', 'update', 'destroy']);
        Route::resource('/sublevels', 'Admin\SublevelController')->only(['store', 'update', 'destroy']);
        Route::resource('/courses', 'Admin\CourseController')->only(['store', 'update', 'destroy']);

        // Manage Exams
        Route::group(['prefix' => 'exams', 'as' => 'exams.'], function () {
            Route::get('/','Admin\ExamController@index')->name('index');
            Route::get('/{level_id}','Admin\ExamController@level_show')->name('level.show');
            Route::get('/{level_id}/create', 'Admin\ExamController@sublevel_create')->name('sublevel.create');
            Route::get('/{level_id}/{sublevel_id}/edit', 'Admin\ExamController@sublevel_edit')->name('sublevel.edit');
            Route::get('/{level_id}/{sublevel_id}/questions', 'Admin\ExamController@manage_question')->name('sublevel.questions');
        });

        // Logout
        Route::get('/logout', 'Admin\AuthController@logout')->name('logout');
    });

});
