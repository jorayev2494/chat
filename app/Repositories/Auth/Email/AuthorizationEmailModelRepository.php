<?php

namespace App\Repositories\Auth\Email;

use App\Http\DTOs\Api\Auth\Email\RegisterEmailRequestDTO;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\Auth\AuthorizationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AuthorizationEmailModelRepository extends BaseModelRepository implements AuthorizationRepositoryInterface {

    /**
     * @param RegisterEmailRequestDTO $registerEmailRequestDTO
     * @return Model
     */
    public function registerEmail(RegisterEmailRequestDTO $registerEmailRequestDTO): Model
    {
        /** @var Model $model */
        $model = $this->getModeClone()->create([
            'email' => $registerEmailRequestDTO->email,
            'password' => $registerEmailRequestDTO->password,
        ]);

        return $model;
    }

}