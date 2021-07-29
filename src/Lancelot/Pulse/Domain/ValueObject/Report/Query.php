<?php


namespace Lancelot\Pulse\Domain\ValueObject\Report;


use Illuminate\Support\Collection;

class Query
{
    private string $value;
    
    public function __construct(string $value)
    {
        $this->value = $value;
    }
    
    public function execute() : Collection
    {
        $a = json_decode($this->value);
        dd(213);
    }
}
