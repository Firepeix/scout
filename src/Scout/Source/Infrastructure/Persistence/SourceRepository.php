<?php


namespace Scout\Source\Infrastructure\Persistence;


use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Shared\Infrastructure\Persistence\AbstractRepository;
use Scout\Source\Domain\Source;
use Scout\Source\Domain\SourceInterface;
use Scout\Source\Domain\SourceRepository as SourceRepositoryContract;
use Scout\Source\Domain\ValueObject\SourceId;
use Scout\Source\Domain\ValueObject\Template;
use Scout\Source\Domain\ValueObject\Type;

class SourceRepository extends AbstractRepository implements SourceRepositoryContract
{
    public function __construct(SourceModel $model)
    {
        parent::__construct($model);
    }
    
    protected function map($model): SourceInterface
    {
        $template = $model->template !== '' ? new Template($model->template) : null;
        return new Source(new SourceId($model->id), new Type($model->type), $template);
    }
    
    public function findSourceByType(SourceType $sourceType): SourceInterface
    {
        return $this->map($this->model::where('type', $sourceType->value())->firstOrFail());
    }
}
