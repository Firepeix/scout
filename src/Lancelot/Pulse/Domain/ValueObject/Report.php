<?php


namespace Lancelot\Pulse\Domain\ValueObject;


use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\ValueObject\Report\Query;

class Report
{
    private Query $query;
    
    public function __construct(Query $query)
    {
        $this->query = $query;
    }
    
    public function retrieve() : Collection
    {
        return $this->query->execute();
    }
}
