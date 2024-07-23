<?php

namespace App\Http\Controllers\Api\V1;

//use App\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\ApiController as ApiController;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request , TicketFilter $filters)
    {
        /*if($this->include('author',$request)){
            return TicketResource::collection(Ticket::with('user')->paginate());
        }
        return TicketResource::collection(Ticket::paginate());
        */

        return TicketResource::collection(Ticket::filter($filters)->paginate());

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        try{
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        }catch(ModelNotFoundException $exception){
            return $this->ok('User not found',[
                'error' => 'The provided user id does not exists'
            ]);
        }

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.author.data.id')
        ];

        return new TicketResource(Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket,Request $request)
    {
        if($this->include('author',$request)){
            return new TicketResource($ticket->load('user'));
        }

        return new TicketResource($ticket);
        //以下方法也通用
        //return TicketResource::make($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}