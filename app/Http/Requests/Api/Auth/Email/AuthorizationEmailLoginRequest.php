<?php

namespace App\Http\Requests\Api\Auth\Email;

use App\Services\Api\Auth\Enums\GuardEnum;
use Illuminate\Foundation\Http\FormRequest;

class AuthorizationEmailLoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }
}
