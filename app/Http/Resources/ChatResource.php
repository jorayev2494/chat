<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Chat $resource
 */
class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'status_id' => $this->resource->status_id,
            $this->mergeWhen($this->resource->relationLoaded('status'), ['type' => $this->resource->status->status]),
            
            // Merges
            'messages_unseen_count' => $this->when(
                array_key_exists('messages_unseen_count', $this->resource->attributesToArray()),
                $this->resource->messages_unseen_count
            ),
            'last_message' => $this->when(
                array_key_exists('last_message', $this->resource->attributesToArray()),
                MessageResource::make($this->resource->last_message)
            ),
            
            // Relations
            'members' => UserResource::collection($this->whenLoaded('members')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),

            'deleted_at' => $this->resource->deleted_at,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
