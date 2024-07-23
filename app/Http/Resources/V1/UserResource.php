<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                /*'emailVerifiedAt' => $this->when(
                    $request->routeIs('users.*'),
                    $this->email_verified_at
                ),
                'updatedAt' => $this->when(
                    $request->routeIs('users.*'),
                    $this->updated_at
                ),
                'createdAt' => $this->when(
                    $request->routeIs('users.*'),
                    $this->created_at
                ),
                以上可以用以下程式碼簡略
                */
                $this->mergeWhen($request->routeIs('authors.*'),[
                    'emailVerifiedAt' => $this->email_verified_at,
                    'updatedAt' => $this->updated_at,
                    'createdAt' => $this->created_at
                ])
            ],
            'includes' => TicketResource::collection($this->whenLoaded('tickets')),
            'links' => [
                'self' => route('authors.show', ['author' => $this->id])
            ]
        ];
    }
}
