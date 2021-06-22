<?php


namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Shared\Repositories\Repository;
use App\Infrastructure\Persistence\Models\AbstractModel;
use Illuminate\Support\Collection;

abstract class AbstractRepository implements Repository
{
    private AbstractModel $model;
    
    public function __construct(AbstractModel $model)
    {
        $this->model = $model;
    }
    
    public function getAll(): Collection
    {
        return $this->model::all()->map(fn ($manga) => $this->map($manga));
    }
    
    public function find(string $id): mixed
    {
        return $this->map($this->model::find($id));
    }
    
    abstract protected function map($model) : mixed;
}
