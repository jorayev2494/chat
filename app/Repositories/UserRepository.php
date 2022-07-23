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

    /**
     * @param integer $phoneCountryId
     * @param string $phone
     * @return User
     */
    public function findUserByPhoneCountryIdAndPhoneNumber(int $phoneCountryId, string $phone): User
    {
        return $this->getModeClone()->newQuery()->where([
                                                                ['phone_country_id', '=', $phoneCountryId],
                                                                ['phone', '=', $phone],
                                                            ])
                                                            ->firstOrFail();
    }

}