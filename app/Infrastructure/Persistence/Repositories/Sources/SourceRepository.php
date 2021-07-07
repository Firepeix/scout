<?php


namespace App\Infrastructure\Persistence\Repositories\Sources;

use App\Domain\Sources\Repositories\SourceRepository as SourceRepositoryContract;
use App\Domain\Sources\Source;
use App\Infrastructure\Persistence\Models\Sources\Source as SourceModel;
use App\Infrastructure\Persistence\Repositories\AbstractRepository;
use App\Infrastructure\Sources\MangaDexSource;
use App\Infrastructure\Sources\MklotSource;
use App\Infrastructure\Sources\MNatoSource;

class SourceRepository extends AbstractRepository implements SourceRepositoryContract
{
    public function __construct(SourceModel $model)
    {
        parent::__construct($model);
    }
    
    protected function map($model): Source
    {
        return [
            MklotSource::TYPE => fn() => new MklotSource($model->template, $model->type),
            MNatoSource::TYPE => fn() => new MNatoSource($model->template, $model->type),
            MangaDexSource::TYPE => fn() => new MangaDexSource($model->type)
        ][$model->type]();
    }
}
