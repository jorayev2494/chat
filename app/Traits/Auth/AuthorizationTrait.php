<?php

declare(strict_types=1);

namespace App\Traits\Auth;

trait AuthorizationTrait
{
    /**
     * @param string $token
     * @return array
     */
    protected function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}