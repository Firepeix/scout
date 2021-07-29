<?php

namespace Lancelot\Pulse\Domain\ValueObject;

use ArrayIterator;
use Countable;
use Illuminate\Support\Collection;
use IteratorAggregate;

class Reports implements IteratorAggregate, Countable
{
    private Collection $value;
    
    public function __construct(Collection $reports)
    {
        $this->value = $reports;
    }
    
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->value->all());
    }
    
    public function count() : int
    {
        return $this->value->count();
    }
}
