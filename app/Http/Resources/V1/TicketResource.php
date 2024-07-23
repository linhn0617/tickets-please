<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

//使用Resource將payload的格式進行轉換
class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

     //public static $wrap = 'ticket'   使用static $wrap來改變data wrapper

    public function toArray(Request $request): array
    {
        return[
            'type' => 'ticket',
            'id' =>$this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                   $request->routeIs('tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updatedAt
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id
                    ],
                    'links' => [
                        'self' => route('authors.show', ['author' => $this->user_id])
                    ]
                ]
            ],
            'includes' => new UserResource($this->whenLoaded('author')),
            'links' => [
                'self' => route('tickets.show', ['ticket' => $this->id])
            ]
        ];
    }
}