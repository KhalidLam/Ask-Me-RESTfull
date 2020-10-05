<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Auth Route
Route::post('auth', 'API\UserController@authLogin')->name('user.authLogin');
Route::post('authRegister', 'API\UserController@authRegister')->name('user.authRegister');

Route::post('login', 'API\UserController@login')->name('user.login');
Route::post('register', 'API\UserController@register')->name('user.register');


// Users
Route::get('users', 'API\UserController@index')->name('user.index');
Route::get('users/{user}', 'API\UserController@show')->name('user.show');


// Route required auth
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('auth', 'API\UserController@authData')->name('user.authData');

    Route::post('logout', 'API\UserController@logout')->name('user.logout');
    Route::post('details', 'API\UserController@details')->name('user.details');

    // Question Route
    Route::resource('questions', 'QuestionsController')->except(['index', 'show']);

    // Comments Route
    Route::post('/comments', 'CommentController@store')->name('comments.store');
    Route::delete('/comments/{comment}', 'CommentController@destroy')->name('comments.destroy');

    // Answers Route
    Route::post('/answers/{slug}', 'AnswerController@store')->name('answers.store');
    Route::delete('/answers/{answer}', 'AnswerController@destroy')->name('answers.destroy');

});


// Question Route
Route::get('/questions', 'QuestionsController@index')->name('questions.index');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');

// Comments Route
Route::get('/comments/{slug}', 'CommentController@show')->name('comments.show');

// Answers Route
Route::get('/answers/{slug}', 'AnswerController@show')->name('answers.show');

