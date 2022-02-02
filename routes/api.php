<?php

use App\Http\Controllers\MovieRatingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// La tabella del database deve essere movieratings

Route::apiResource('/movie_ratings', MovieRatingController::class);

// Route::get('petitions/category/{category}', [PetitionController::class, 'getPetitionByCategory']);
Route::get('movie_ratings/id/{id}', [MovieRatingController::class, 'getMovieRatingsById']);

Route::get('movie_ratings/user_id/{user_id}', [MovieRatingController::class, 'getMovieRatingsByUserId']);

Route::get('movie_ratings/id/{movie_id}/movie_id/{user_id}', [MovieRatingController::class, 'getMovieRatingsByUserAndMovieId']);
