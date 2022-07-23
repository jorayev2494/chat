<?php

declare(strict_types=1);

namespace App\Traits\Auth;

use App\Models\Device;

trait AuthorizationTrait
{
    /**
     * @param string $token
     * @return array
     */
    protected function respondWithToken(string $token, Device $device): array
    {
        return array_merge([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], [
            'ws_token' => $device->ws_token
        ]);
    }
}