<?php

namespace Shared\Infrastructure\Events;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Subscribe
{
    private string $event;
    
    public function __construct(string $event)
    {
        $this->event   = $event;
    }
    
    public function getEventName(): string
    {
        return $this->event;
    }
}
