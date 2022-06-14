<?php

namespace App\Repositories\Base;

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
    public abstract function getModel(): string;

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
}