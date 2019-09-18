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
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('/questions', 'QuestionsController@index');
	Route::post('/questions', 'QuestionsController@createQuestion');
// Route::get('/question/{id}', 'QuestionsController@questionid');
Route::get('/questions/{id}', 'QuestionsController@show');
Route::post('/questions/{id}', 'QuestionsController@updateQuestion');
Route::get('/questions/{id}/delete', 'QuestionsController@destroy');

Route::get('/questions/{id}/answers', 'AnswersController@index');
Route::post('/questions/{id}/answers', 'AnswersController@createAnswer');
Route::get('/questions/{id}/answers/{answerid}', 'AnswersController@show');
Route::post('/questions/{id}/answers/{answerid}', 'AnswersController@updateAnswer');
Route::get('/questions/{id}/answers/{answerid}/delete', 'AnswersController@destroy');

Route::get('/questions/{id}/answers/{answerid}/comments', 'CommentsController@index');
Route::post('/questions/{id}/answers/{answerid}/comments', 'CommentsController@createComment');
Route::get('/questions/{id}/answers/{answerid}/comments/{commentid}', 'CommentsController@show');
Route::post('/questions/{id}/answers/{answerid}/comments/{commentid}', 'CommentsController@updateComment');
Route::get('/questions/{id}/answers/{answerid}/comments/{commentid}/delete', 'CommentsController@destroy');
Route::get('/all/logoutt', 'AuthController@logoutApi');

});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
// Route::get('/all/logoutt', 'AuthController@logoutApi');
