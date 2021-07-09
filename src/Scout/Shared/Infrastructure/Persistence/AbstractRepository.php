<?php


namespace Scout\Shared\Infrastructure\Persistence;

use Illuminate\Support\Collection;
use Scout\Shared\Domain\Repositories\Repository;
use Shared\Domain\ValueObject\Id;

abstract class AbstractRepository implements Repository
{
    protected ?AbstractModel $model;
    
    public function __construct(AbstractModel $model = null)
    {
        $this->model = $model;
    }
    
    public function getAll(): Collection
    {
        return $this->model::all()->map(fn ($model) => $this->map($model));
    }
    
    public function find(Id $id): mixed
    {
        return $this->map($this->model::find($id));
    }
    
    abstract protected function map($model) : mixed;
}
