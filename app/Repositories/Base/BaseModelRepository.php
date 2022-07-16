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
     * @var string[] $columns
     */
    private array $columns = ['*'];

    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param string ...$columns
     * @return self
     */
    public function setColumns(string ...$columns): self
    {
        $this->columns = $columns;

        return $this;
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

    public function findByOrFail(string $column, string $value, array $columns = null): Model
    {
        return $this->getModeClone()->newQuery()->where($column, $value)->select($columns ?: $this->columns)->firstOrFail();
    }

    public function findByOrNull(string $column, string $value, array $columns = null): Model
    {
        return $this->getModeClone()->newQuery()->where($column, $value)->select($columns ?: $this->columns)->first();
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