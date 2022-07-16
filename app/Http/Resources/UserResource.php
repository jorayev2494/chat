<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
class UserResource extends JsonResource
{
    // private array $defaultAvatars = [
    //     'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars.png',
    //     'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars-3.png',
    //     'https://www.disneyplusinformer.com/wp-content/uploads/2021/06/Luca-Profile-Avatars-2.png'
    // ];

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
            'last_name' => $this->resource->last_name,
            'first_name' => $this->resource->first_name,
            'avatar' => $this->resource->avatar,
            'phone' => $this->resource->phone,
            'phone_country' => CountryResource::make($this->whenLoaded('phoneCountry')),
            $this->mergeWhen(
                array_key_exists('first_name', $this->resource->attributesToArray()) && array_key_exists('first_name', $this->resource->attributesToArray()),
                fn () => ['full_name' => $this->resource->fullName]
            ),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'email' => $this->resource->email,
            'is_admin' => $this->resource->is_admin,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
