<?php

declare(strict_types=1);

namespace App\Http\DTOs\Api\Auth\Phone;

use App\DTOs\Contracts\FromRequestDTO;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RegisterPhoneRequestDTO extends DataTransferObject implements FromRequestDTO
{
    public readonly string $phone_code;
    public readonly int $phone_country_id;
    public readonly string $phone;

    /**
     * @param Request|FormRequest $formRequest
     * @return static
     */
    public static function makeFromRequest(Request|FormRequest $formRequest): static
    {
        return new static(
            phone_country_id: $formRequest->get('phone_country_id'),
            phone: $formRequest->get('phone'),
            phone_code: $formRequest->get('phone_code')
        );
    }
}