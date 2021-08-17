<?php

namespace Lancelot\Pulse\Domain\ValueObject;

use Illuminate\Support\Collection;

class Report
{
    private Query $query;
    private ?int $goal;
    
    public function __construct(Query $query, int $goal = null)
    {
        $this->query = $query;
        $this->goal = $goal;
    }
    
    public function getGoal(): ?int
    {
        return $this->goal;
    }
    
    public function retrieve() : Collection
    {
        return $this->query->execute();
    }
}
