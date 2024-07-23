<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,AuthorFilter $filters)
    {
        
        return UserResource::collection(User::filter($filters)->paginate());
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $author, Request $request)
    {
        if ($this->include('tickets',$request)){
            return new UserResource($author->load('tickets'));
        }
        return new UserResource($author);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
