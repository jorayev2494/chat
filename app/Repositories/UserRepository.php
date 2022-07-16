<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Auth\Email\AuthorizationEmailModelRepository;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\Auth\AuthorizationEmailRepositoryInterface;
use App\Repositories\Contracts\Auth\AuthorizationRepositoryInterface;

class UserRepository extends AuthorizationEmailModelRepository
{
    /**
     * @return string
     */
    protected function getModel(): string
    {
        return User::class;
    }

}