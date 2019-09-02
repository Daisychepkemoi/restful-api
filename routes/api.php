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
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('/questions', 'QuestionsController@index');
// Route::get('/question/{id}', 'QuestionsController@questionid');
Route::get('/questions/{id}', 'QuestionsController@show');
Route::get('/questions/{id}/delete', 'QuestionsController@destroy');

Route::get('/questions/{id}/answers', 'AnswersController@index');
Route::get('/questions/{id}/answers/{answerid}', 'AnswersController@show');
Route::get('/questions/{id}/answers/{answerid}/delete', 'AnswersController@destroy');

Route::get('/questions/{id}/answers/{answerid}/comments', 'CommentsController@index');
// Route::post('register', 'API\RegisterController@register');
 // http://localhost:8000/api/products
// Route::middleware('auth:api')->group( function () {
// 	Route::resource('questions', 'QuestionsController');
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();

// });
