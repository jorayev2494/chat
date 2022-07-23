<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Message $resource
 */
class MessageResource extends JsonResource
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
            'chat_id' => $this->resource->chat_id,
            'user_id' => $this->when(
                !$this->resource->relationLoaded('user'),
                $this->resource->user_id
            ),
            'text' => $this->resource->text,
            'user' => UserResource::make($this->whenLoaded('user')),
            'parent_id' => $this->resource->parent_id,
            'is_seen' => $this->when(
                $this->resource->relationLoaded('see'),
                $this->resource->see?->is_seen
            ),
            'medias' => MediaResource::collection($this->whenLoaded('medias')),
            'deleted_at' => $this->when(
                false,
                $this->resource->deleted_at
            ),
            'is_seen' => $this->when($this->resource->relationLoaded('see'), $this->resource->see?->is_seen),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->created_at,
        ];
    }
}
