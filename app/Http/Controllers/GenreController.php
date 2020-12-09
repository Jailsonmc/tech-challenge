<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasFetchAllRenderCapabilities;
use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

//use App\Article;
//use App\Comment;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
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
        $this->setGetAllBuilder(Genre::query());
        $this->setGetAllOrdering('name', 'asc');
        $this->parseRequestConditions($request);
        return new ResourceCollection($this->getAll()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param GenreRequest $request
     * @return \App\Http\Resources\Genre
     */
    public function store(GenreRequest $request)
    {
        $genre = new Genre($request->validated());
        $genre->save();

        return new \App\Http\Resources\Genre($genre);
    }

    /**
     * Show the resource
     *
     * @param Genre $genre
     * @return \App\Http\Resources\Genre
     */
    public function show(Genre $genre)
    {
        return new \App\Http\Resources\Genre($genre);
    }

    /**
     * Show the resource
     *
     * @param Genre $genre
     * @return \App\Http\Resources\Genre
     */
    public function show_movies(Genre $genre) {

        $movies = $genre->movies;
        if (count($movies) > 0) {
            return response()->json(['message' => 'Success', 'data' => $movies], 200);
            //return new \App\Http\Resources\Genre($genre);
        } 
        return response()->json(['message' => 'No Comment Found', 'data' => null], 200);
        //return new \App\Http\Resources\Genre($genre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Genre $genre
     * @param GenreRequest $request
     * @return \App\Http\Resources\Genre
     */
    public function update(Genre $genre, GenreRequest $request)
    {
        $genre->fill($request->validated());
        $genre->save();

        return new \App\Http\Resources\Genre($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Genre $genre
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->noContent();
    }
}
