<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\FileTrait;
use Illuminate\Support\Collection;

class UserServices
{

    use FileTrait;

    public function __construct(
        private UserRepository $repository
    )
    {
        
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->repository->get();
    }

    /**
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {



        $user->update($data);

        return $user;
    }
}