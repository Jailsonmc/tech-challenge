<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Traits\HasFetchAllRenderCapabilities;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MovieController extends Controller
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
        $this->setGetAllBuilder(Movie::query());
        $this->setGetAllOrdering('name', 'asc');
        $this->parseRequestConditions($request);
        return new ResourceCollection($this->getAll()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param MovieRequest $request
     * @return \App\Http\Resources\Movie
     */
    public function store(MovieRequest $request)
    {
        $movie = new Movie($request->validated());
        $movie->save();

        return new \App\Http\Resources\Movie($movie);
    }

    /**
     * Show the resource
     *
     * @param Movie $movie
     * @return \App\Http\Resources\Movie
     */
    public function show(Movie $movie)
    {
        return new \App\Http\Resources\Movie($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Movie $movie
     * @param MovieRequest $request
     * @return \App\Http\Resources\Movie
     */
    public function update(Movie $movie, MovieRequest $request)
    {
        $movie->fill($request->validated());
        $movie->save();

        return new \App\Http\Resources\Movie($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Movie $movie
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->noContent();
    }
}
