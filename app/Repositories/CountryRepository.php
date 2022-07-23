<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository extends BaseModelRepository
{
    /**
     * @return string
     */
    protected function getModel(): string
    {
        return Country::class;
    }
    
    /**
     * @return Collection
     */
    public function getPublicCountries(): Collection
    {
        return $this->getModeClone()->newQueryWithoutRelationships()->orderBy('name')->get();
    }
}