<?php

namespace App\Repositories\Contracts\Auth;

use App\Http\DTOs\Api\Auth\Email\EmailRegisterRequestDTO;
use App\Repositories\Contracts\Auth\Email\AuthorizationEmailRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface AuthorizationRepositoryInterface extends AuthorizationEmailRepositoryInterface {
    
}