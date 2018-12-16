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

Route::get('ratings', 'Rating\RatingController@loadMovieRatings');

Route::get('ratings/ages/{ageId}', 'Rating\RatingController@searchByAge');

Route::get('ratings/genres/{genre}', 'Rating\RatingController@searchByGenre');

Route::get('ages/{ageId}', 'Age\AgeController@getAgeById');

Route::get('movies/genres', 'Movie\MovieController@loadMovieGenres');

Route::get('ratings/paginated', 'Rating\RatingController@loadPaginatedChartRecords');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

