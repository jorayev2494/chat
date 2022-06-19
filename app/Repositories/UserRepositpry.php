<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseModelRepository;

class UserRepository extends BaseModelRepository
{
    /**
     * @return string
     */
    protected function getModel(): string
    {
        return User::class;
    }

}