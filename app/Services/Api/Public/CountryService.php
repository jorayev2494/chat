<?php

declare(strict_types=1);

namespace App\Services\Api\Public;

use App\Repositories\CountryRepository;
use Illuminate\Support\Collection;

class CountryService
{
    public function __construct(
        private CountryRepository $repository
    )
    {
        
    }

    /**
     * @return Collection
     */
    public function getPublicCounties(): Collection
    {
        return $this->repository->getPublicCountries();
    }
}