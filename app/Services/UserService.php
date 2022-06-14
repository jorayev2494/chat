<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class UserServices
{
    public function __construct(
        private User $repository
    )
    {
        
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->repository->newQuery()->get();
    }
}