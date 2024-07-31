<?php

namespace App\Policies\V1;

use App\Models\Ticket;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket)
    {
        if($user->tokenCan(Abilities::DeleteTicket)){
            return true;
        }else if($user->tokenCan(Abilities::DeleteOwnTicket)){
            return $user->id === $ticket->user_id;
        }
        
        return false;
    }

    public function replace(User $user, Ticket $ticket)
    {
        return $user->tokenCan(Abilities::ReplaceTicket);
    }


    public function store(User $user)
    {
        return $user->tokenCan(Abilities::CreateTicket)||$user->tokenCan(Abilities::CreateOwnTicket);
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket)
    {
        if($user->tokenCan(Abilities::UpdateTicket)){
            return true;
        }else if($user->tokenCan(Abilities::UpdateOwnTicket)){
            return $user->id === $ticket->user_id;
        }
        
        return false;
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        //
    }
}
