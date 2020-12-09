<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActorRoleController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'genres' => GenreController::class,
]);

Route::get('genres/{genre}/movies','GenreController@show_movies');

Route::resources([
    'actors' => ActorController::class,
]);

Route::resources([
    'movies' => MovieController::class,
]);

Route::resources([
    'actor_roles' => ActorRoleController::class,
]);

Route::get('actor_roles/{actor}/movies','ActorRoleController@showMoviesByActor');

Route::get('actor_roles/{actor}/genres','ActorRoleController@showGenresByActor');

Route::get('actor_roles_actors/{genre}/actors',function($genre) {
	return ActorRoleController::showActorsByGenreOrderMovie($genre);
});

Route::get('actor_roles_movies/{actor}/{genre}/movies',function($actor, $genre) {
	return ActorRoleController::showMoviesByGenreByActor($actor,$genre);
});
