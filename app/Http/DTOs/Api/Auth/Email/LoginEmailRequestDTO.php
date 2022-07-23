<?php

namespace App\Http\DTOs\Api\Auth\Email;

use App\DTOs\Contracts\FromRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

final class LoginEmailRequestDTO extends DataTransferObject implements FromRequestDTO
{
    public readonly string $email;
    public readonly string $password;
    public readonly bool $shouldRemember;
    public readonly string $device_id;

    public static function makeFromRequest(Request|FormRequest $formRequest): self
    {
        return new static(
            email: $formRequest->get('email'),
            password: $formRequest->get('password'),
            shouldRemember: $formRequest->has('remember_me'),
            device_id: $formRequest->get('device_id')
        );
    }
}