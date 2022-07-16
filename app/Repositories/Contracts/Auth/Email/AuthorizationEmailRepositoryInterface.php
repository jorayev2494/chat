<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\Auth\Email;

use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use Illuminate\Database\Eloquent\Model;

interface AuthorizationEmailRepositoryInterface {
    public function registerEmail(RegisterEmailRequestDTO $emailRegisterRequestDTO): Model;
}