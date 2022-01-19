<?php

namespace Executor\Manager\Domain\ValueObject;

class Body
{
    private string $rawBody;
    
    public function __construct(string $rawBody)
    {
        $this->rawBody = $rawBody;
    }
    
    public function array(): array
    {
        return json_decode($this->rawBody, true);
    }
}
