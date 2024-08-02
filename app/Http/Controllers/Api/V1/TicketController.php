<?php

namespace App\Http\Controllers\Api\V1;

//use App\Controllers\Api\V1\ApiController;
use App\Http\Controllers\Api\V1\ApiController as ApiController;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;
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
        //$user = User::findOrFail($request->input('data.relationships.author.data.id'));
        //instead by line 28 in app/Http/Requests/Api/V1/StoreTicketRequest.php
        //policy
        if($this->isAble('store', Ticket::class)){
            return new TicketResource(Ticket::create($request->mappedAttributes()));
        }
        
        return $this->error('You are not authorized to update that resource', 401);
    }

    /**
     * Display the specified resource.
     */
    public function show($ticket_id,Request $request)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);
            if($this->include('author',$request)){
            return new TicketResource($ticket->load('user'));
        }

        return new TicketResource($ticket);
        //以下方法也通用
        //return TicketResource::make($ticket);
        }catch(ModelNotFoundException $exception){
            return $this->error('Ticket cannot be found.', 404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        //PATCH
        try{
            $ticket = Ticket::findOrFail($ticket_id);

            if($this->isAble('update', $ticket)){
                $ticket->update($request->mappedAttributes());

                return new TicketResource($ticket);
            }

            return $this->error('You are not authorized to update that resource', 401);
        }catch(ModelNotFoundException $exception){
            return $this->error('Ticket cannot be found.', 404);
        }
    }

    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        //PUT
        try{
            $ticket = Ticket::findOrFail($ticket_id);

            if($this->isAble('replace', $ticket)){
                $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);
            }
            return $this->error('You are not authorized to update that resource', 401);
        }catch(ModelNotFoundException $exception){
            return $this->error('Ticket cannot be found.', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ticket_id)
    {
        try{
            $ticket = Ticket::findOrFail($ticket_id);

            //policy
            if($this->isAble('delete', $ticket)){
                $ticket->delete();
                
                return $this->ok('Ticket successfully deleted');
            }
            
            return $this->error('You are not authorized to delete that resource', 401);
        }catch(ModelNotFoundException $exception){
            return $this->error('Ticket cannot found.', 404);
        }
    }
}
