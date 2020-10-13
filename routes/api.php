<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api\Auth', 'as' => 'api.', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');
    Route::post('logout', 'AuthController@logout')->name('logout');
    Route::post('refresh', 'AuthController@refresh')->name('refresh');
    Route::get('user-profile', 'AuthController@userProfile')->name('user-profile');
    Route::get('all-users', 'AuthController@allUsers')->name('all-users');
});

Route::group(['namespace' => 'Api', 'as' => 'api.', 'middleware' => 'jwt'], function () {
    Route::apiResource('/students', 'StudentController');
    Route::apiResource('/courses', 'CourseController');
    Route::get('/student_courses/{student}', 'StudentCourseController@index')->name('student_courses');
    Route::post('/add_student_course/{course}', 'StudentCourseController@addStudentCourse')->name('add_student_course');
});
