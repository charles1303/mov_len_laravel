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



Route::post('token', [ 'as' => 'login', 'uses' => 'PassportController@getAccessToken']);

Route::get('token', [ 'as' => 'login', 'uses' => 'PassportController@getAccessToken']);

Route::post('register', [ 'as' => 'register', 'uses' => 'PassportController@register']);

Route::get('oauth', [ 'as' => 'oauth', 'uses' => 'PassportController@getOAuthDetails']);

Route::get('tokenRequest', [ 'as' => 'oauth', 'uses' => 'PassportController@tokenRequest']);

Route::post('assignScope', [ 'as' => 'assignScope', 'uses' => 'PassportController@assignTokenScope']);




Route::middleware('auth:api')->group(function () {
    Route::get('user', [ 'as' => 'user', 'uses' => 'PassportController@details'])->middleware('scopes:users');
    
    Route::get('ratings', 'Rating\RatingController@loadMovieRatings')->middleware('scopes:ratings');
    
    Route::get('ratings/genres/{genre}', 'Rating\RatingController@searchByGenre')->middleware('scopes:ratings');
    
    Route::get('ratings/ages/{ageId}', 'Rating\RatingController@searchByAge')->middleware('scopes:ratings');
    
    Route::get('ages/{ageId}', 'Age\AgeController@getAgeById')->middleware('scopes:ages');
    
    Route::get('movies/genres', 'Movie\MovieController@loadMovieGenres')->middleware('scopes:movies');
    
    Route::get('ratings/paginated', 'Rating\RatingController@loadPaginatedChartRecords')->middleware('scopes:ratings');
});

