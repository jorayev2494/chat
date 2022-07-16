<?php

namespace App\Http\Requests\Api\Profile;

use App\Services\Api\Auth\Enums\GuardEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guard(GuardEnum::API->value)->check();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'avatar' => 'image|mimetypes:image/jpg,image/jpeg,image/png',
            'email' => "email|unique:users,email," . auth()->guard()->id() . ",id",
            'phone' => 'string',
            'phone_country_id' => 'integer|exists:countries,id',
            'country_id' => 'integer|exists:countries,id',
        ];
    }
}
