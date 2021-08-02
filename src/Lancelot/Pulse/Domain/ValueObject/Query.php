<?php

namespace Lancelot\Pulse\Domain\ValueObject;

use Exception;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lancelot\Context\Domain\Context;
use Lancelot\Context\Domain\ValueObject\Field\Field;
use Lancelot\Context\Domain\ValueObject\Table\Fields;
use Lancelot\Context\Domain\ValueObject\Table\Table;

class Query
{
    private const MONGO     = 'mongo';
    private const TYPE_POS  = 0;
    private const VALUE_POS = 1;
    private const CONTENT_POS = 2;
    
    private array   $baseQuery;
    private Context $context;
    
    public function __construct(array $baseQuery, Context $context)
    {
        $this->baseQuery = $baseQuery;
        $this->context   = $context;
    }
    
    public function execute(): Collection
    {
        $engines = [
            self::MONGO => fn() => $this->executeMongo()
        ];
        
        $engine = $this->context->getDatabase()->getEngineName();
        
        if (isset($engines[$engine])) {
            return $engines[$engine]();
        }
        throw new Exception("Motor $engine não suportado");
    }
    
    private function executeMongo(): Collection
    {
        $table      = $this->getSourceTable();
        $fields     = $table->getFields();
        $connection = $this->getConnection();
        return $this->build($connection->collection($table->getName()), $fields)->get();
    }
    
    private function getSourceTable(): Table
    {
        return $this->context->getTables()->findById($this->baseQuery['query']['source-table']);
    }
    
    private function getConnection(): ConnectionInterface
    {
        return DB::connection($this->context->getDatabase()->getConnection());
    }
    
    private function build(Builder $process, Fields $fields) : Builder
    {
        $this->applySelect($process, $fields);
        $this->applyOrderBy($process, $fields);
        $this->applyFilters($process, $fields);
        
        return $process;
    }
    
    private function applySelect(Builder $builder, Fields $fields): void
    {
        $selects = $this->baseQuery['query']['fields'] ?? null;
        if ($selects !== null) {
            $selectBy = [];
            foreach ($selects as $select) {
                if ($select[self::TYPE_POS] === Field::DESCRIPTOR) {
                    $id = $select[self::VALUE_POS];
                    $selectBy[] = $fields->findById($id)->getContextFieldName();
                }
            }
            $builder->select($selectBy);
        }
    }
    
    private function applyOrderBy(Builder $builder, Fields $fields): void
    {
        $orderBys = $this->baseQuery['query']['order-by'] ?? null;
        if ($orderBys !== null) {
            foreach ($orderBys as $orderBy) {
                if ($orderBy[self::VALUE_POS][self::TYPE_POS] === Field::DESCRIPTOR) {
                    $id = $orderBy[self::VALUE_POS][self::VALUE_POS];
                    $builder->orderBy($fields->findById($id)->getContextFieldName(), $orderBy[0]);
                }
            }
        }
    }
    
    private function applyFilters(Builder $builder, Fields $fields): void
    {
        $filters = $this->baseQuery['query']['filter'] ?? null;
        $filters = count($filters) === 3 ? [$filters] : $filters;
        if ($filters !== null) {
            foreach ($filters as $filter) {
                if ($filter[self::VALUE_POS][self::TYPE_POS] === Field::DESCRIPTOR) {
                    $id = $filter[self::VALUE_POS][self::VALUE_POS];
                    $column = $fields->findById($id)->getContextFieldName();
                    $builder->where($column, $filter[self::TYPE_POS], $filter[self::CONTENT_POS]);
                }
            }
        }
    }
}
