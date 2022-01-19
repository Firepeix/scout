<?php

namespace Shared\Infrastructure\Application;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ApplicationCommand
{
    private string $name;
    
    public function __construct(string $name)
    {
        $this->name   = $name;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
