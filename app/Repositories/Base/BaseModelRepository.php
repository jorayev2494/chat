<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModelRepository
{
    /**
     * @var Model|null $model
     */
    private ?Model $model;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @return string
     */
    protected abstract function getModel(): string;

    /**
     * @return void
     */
    private function initialize()
    {
       $this->model = app()->make($this->getModel()); 
    }

    /**
     * @return Model
     */
    public function getModeClone(): Model
    {
        return clone $this->model;
    }

    /**
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->getModeClone()->newQuery()->findOrFail($id);
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function get(array $columns = ['*']): Collection
    {
        return $this->getModeClone()->newQuery()->get($columns);
    }
}