<?php

namespace App\Http\Requests\Api\Auth\Phone;

use App\Services\Api\Auth\Enums\GuardEnum;
use Illuminate\Foundation\Http\FormRequest;

class AuthorizationResentCodeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guard(GuardEnum::API->value)->guest();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone_country_id' => 'required|integer|exists:countries,id|exists:users,phone_country_id',
            'phone' => 'required|integer|exists:users,phone',
        ];
    }
}
