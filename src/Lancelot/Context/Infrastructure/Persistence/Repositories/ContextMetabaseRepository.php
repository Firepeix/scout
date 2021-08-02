<?php

namespace Lancelot\Context\Infrastructure\Persistence\Repositories;

use Closure;
use Illuminate\Support\Collection;
use Lancelot\Context\Domain\Context;
use Lancelot\Context\Domain\Repositories\ContextRepositoryInterface;
use Lancelot\Context\Domain\ValueObject\Database;
use Lancelot\Context\Domain\ValueObject\Field\Field;
use Lancelot\Context\Domain\ValueObject\Field\Id;
use Lancelot\Context\Domain\ValueObject\Field\Name as FieldName;
use Lancelot\Context\Domain\ValueObject\Field\ParentId;
use Lancelot\Context\Domain\ValueObject\Table\Fields;
use Lancelot\Context\Domain\ValueObject\Table\Id as TableId;
use Lancelot\Context\Domain\ValueObject\Table\Name;
use Lancelot\Context\Domain\ValueObject\Table\Table;
use Lancelot\Context\Domain\ValueObject\Tables;
use Lancelot\Context\Infrastructure\Persistence\Models\FieldModel;
use Lancelot\Context\Infrastructure\Persistence\Models\TableModel;

class ContextMetabaseRepository implements ContextRepositoryInterface
{
    public function buildContextFromTableIds(Collection $tableIds): Context
    {
        $tables = TableModel::whereIn('id', $tableIds->toArray())
                              ->with(['fields', 'database'])->get();
        $db = $tables->first()->database;
        $database = new Database($db->details, new Database\Engine($db->engine));
        return new Context($database, new Tables($tables->map($this->getTableMapper())));
    }
    
    private function getTableMapper(): Closure
    {
        return function (TableModel $model) {
            return new Table(new TableId($model->id), new Name($model->name), new Fields($model->fields->map($this->getFieldMapper())));
        };
    }
    
    private function getFieldMapper(): Closure
    {
        return function (FieldModel $model) {
            $parentId = $model->parent_id === null ? null : new ParentId($model->parent_id);
            return new Field(new Id($model->id), new FieldName($model->name), $parentId);
        };
    }
}
