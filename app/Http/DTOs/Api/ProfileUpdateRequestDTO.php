<?php

declare(strict_types=1);

namespace App\Http\DTOs\Api;

use App\DTOs\Contracts\FromRequestDTO;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class ProfileUpdateRequestDTO extends DataTransferObject implements FromRequestDTO
{
    public readonly string $first_name;
    public readonly string $last_name;
    public readonly string $avatar;
    public readonly string $email;
    public readonly string $phone;
    public readonly int $phone_country_id;
    public readonly int $country_id;

    public static function makeFromRequest(Request|FormRequest $formRequest): self
    {
        return new static(
            first_name: $formRequest->get('first_name'),
            last_name: $formRequest->get('last_name'),
            avatar: $formRequest->get('avatar'),
            email: $formRequest->get('email'),
            phone: $formRequest->get('phone'),
            phone_country_id: $formRequest->get('phone_country_id'),
            country_id: $formRequest->get('country_id')
        );
    }
}