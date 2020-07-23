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
Route::post('login', 'API\UserController@login')->name('user.login');
Route::post('register', 'API\UserController@register')->name('user.register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'API\UserController@logout')->name('user.logout');
    Route::post('details', 'API\UserController@details')->name('user.details');
    Route::resource('questions', 'QuestionsController')->except(['index', 'show']);
});

// Question Route
Route::get('/questions', 'QuestionsController@index')->name('questions.index');
Route::get('/questions/{slug}', 'QuestionsController@show')->name('questions.show');
