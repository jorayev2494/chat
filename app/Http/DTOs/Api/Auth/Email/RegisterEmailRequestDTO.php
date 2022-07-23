<?php

declare(strict_types=1);

namespace App\Http\DTOs\Api\Auth\Email;

use App\DTOs\Contracts\FromRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
final class RegisterEmailRequestDTO extends DataTransferObject implements FromRequestDTO
{

    public readonly string $email;
    public readonly string $password;
    
    public static function makeFromRequest(Request|FormRequest $formRequest): self
    {
        return new static(
            email: $formRequest->get('email'),
            password: $formRequest->get('password'),
        );
    }
    
}