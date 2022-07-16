<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserCode;
use App\Repositories\Base\BaseModelRepository;

class UserCodeRepository extends BaseModelRepository {

    protected function getModel(): string
    {
        return UserCode::class;    
    }

}