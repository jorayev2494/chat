<?php

namespace App\Http\Requests\Api\Auth\Phone;

use App\Http\Requests\Api\Base\BaseFormRequest;
use App\Services\Api\Auth\Enums\GuardEnum;

class AuthorizationPhoneCodeRegisterRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guard(GuardEnum::API->value)->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'phone_country_id' => 'required|integer|exists:countries,id',
            'phone' => 'required|integer'
        ];
    }
}
