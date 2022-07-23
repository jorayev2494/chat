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
            'members' => UserResource::collection($this->whenLoaded('members')),
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
            'deleted_at' => $this->resource->deleted_at?->format('Y-d-m H:i:s'),
            'created_at' => $this->resource->created_at?->format('Y-d-m H:i:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-d-m H:i:s'),
        ];
    }
}
