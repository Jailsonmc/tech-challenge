<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Traits\HasFetchAllRenderCapabilities;
use App\Http\Requests\ActorRequest;
use App\Models\Actor;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ActorController extends Controller
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
        $this->setGetAllBuilder(Actor::query());
        $this->setGetAllOrdering('name', 'asc');
        $this->parseRequestConditions($request);
        return new ResourceCollection($this->getAll()->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ActorRequest $request
     * @return \App\Http\Resources\Actor
     */
    public function store(ActorRequest $request)
    {
        $actor = new Actor($request->validated());
        $actor->save();

        return new \App\Http\Resources\Actor($actor);
    }

    /**
     * Show the resource
     *
     * @param Actor $actor
     * @return \App\Http\Resources\actor
     */
    public function show(Actor $actor)
    {
        return new \App\Http\Resources\Actor($actor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Actor $actor
     * @param ActorRequest $request
     * @return \App\Http\Resources\Actor
     */
    public function update(Actor $actor, ActorRequest $request)
    {
        $actor->fill($request->validated());
        $actor->save();

        return new \App\Http\Resources\Actor($actor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Actor $actor
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();

        return response()->noContent();
    }
}
