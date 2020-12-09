<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Traits\HasFetchAllRenderCapabilities;
use App\Http\Requests\ActorRoleRequest;
use App\Models\ActorRole;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Http\Resources\Json\ResourceCollection;

use Illuminate\Support\Facades\DB;

class ActorRoleController extends Controller
{
    use HasFetchAllRenderCapabilities;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $this->setGetAllBuilder(ActorRole::query());
        $this->setGetAllOrdering('role', 'asc');
        $this->parseRequestConditions($request);
        return new ResourceCollection($this->getAll()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ActorRoleRequest $request
     * @return \App\Http\Resources\ActorRole
     */
    public function store(ActorRoleRequest $request)
    {
        $actorRole = new ActorRole($request->validated());
        $actorRole->save();

        return new \App\Http\Resources\ActorRole($actorRole);
    }

    /**
     * Show the resource
     *
     * @param ActorRole $actorRole
     * @return \App\Http\Resources\ActorRole
     */
    public function show(ActorRole $actorRole)
    {
        return new \App\Http\Resources\ActorRole($actorRole);
    }

    public static function showMoviesByActor($actor) {

        $movies = DB::table('actor_roles')
            ->join('actors', 'actor_roles.id_actor', '=', 'actors.id')
            ->join('movies', 'actor_roles.id_movie', '=', 'movies.id')
            ->select('movies.name as movie', 'actor_roles.role')
            ->where('actors.id', '=', $actor)
            ->get();  
        
        if (count($movies) > 0) {
            return response()->json(['message' => 'Success', 'data' => $movies], 200);

        } 
        return response()->json(['message' => 'No Comment Found', 'data' => null], 200);
    }

    public static function showGenresByActor($actor) {
  
        $genres = DB::table('actor_roles')
            ->join('actors', 'actor_roles.id_actor', '=', 'actors.id')
            ->join('movies', 'actor_roles.id_movie', '=', 'movies.id')
            ->join('genres', 'movies.genre', '=', 'genres.name')
            ->select('genres.name as genre', DB::raw('count(genres.name) as starred'))
            ->where('actors.id', '=', $actor)                       
            ->groupBy('genres.name') 
            ->orderByRaw('starred desc') 
            ->limit(1)
            ->get();    

        if (count($genres) > 0) {
            return response()->json(['message' => 'Success', 'data' => $genres], 200);
        } 
        return response()->json(['message' => 'No Comment Found', 'data' => null], 200);
    }

    public static function showMoviesByGenreByActor($actor, $genre) {
  
        $movies = DB::table('actor_roles')
            ->join('actors', 'actor_roles.id_actor', '=', 'actors.id')
            ->join('movies', 'actor_roles.id_movie', '=', 'movies.id')
            ->join('genres', 'movies.genre', '=', 'genres.name')
            ->select('movies.name as movie')
            ->where('actors.id', '=', $actor)->where('genres.name', '=', $genre)                       
            ->groupBy('movies.id')  
            ->get();    

        if (count($movies) > 0) {
            return response()->json(['message' => 'Success', 'data' => $movies], 200);
        } 
        return response()->json(['message' => 'No Comment Found', 'data' => null], 200);
    }

    public static function showActorsByGenreOrderMovie($genre) {
  
        $movies = DB::table('actor_roles')
            ->join('actors', 'actor_roles.id_actor', '=', 'actors.id')
            ->join('movies', 'actor_roles.id_movie', '=', 'movies.id')
            ->join('genres', 'movies.genre', '=', 'genres.name')
            ->select('actors.name as actor')
            ->where('genres.name', '=', $genre)                       
            ->groupBy('actor_roles.id_actor')
            ->orderBy('actor_roles.id_actor')  
            ->get();    

        if (count($movies) > 0) {
            return response()->json(['message' => 'Success', 'data' => $movies], 200);
        } 
        return response()->json(['message' => 'No Comment Found', 'data' => null], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ActorRole $actorRole
     * @param ActorRoleRequest $request
     * @return \App\Http\Resources\ActorRole
     */
    public function update(ActorRole $actorRole, ActorRoleRequest $request)
    {
        $actorRole->fill($request->validated());
        $actorRole->save();

        return new \App\Http\Resources\ActorRole($actorRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ActorRole $actorRole
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ActorRole $actorRole)
    {
        $actorRole->delete();

        return response()->noContent();
    }
}
