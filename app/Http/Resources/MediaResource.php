<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Media $resource
 */
class MediaResource extends JsonResource
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
            'width' => $this->resource->width,
            'height' => $this->resource->height,
            'mime_type' => $this->resource->mime_type,
            'extension' => $this->resource->extension,
            'size' => $this->resource->size,
            'user_file_name' => $this->resource->user_file_name,
            'url' => $this->resource->url,
            'id' => $this->resource->id,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
