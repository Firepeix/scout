<?php

namespace Lancelot\Log\Infrastructure\Events;

class NewLogEvent
{
    private array $log;
    
    public function __construct(array $log)
    {
        $this->log = $log;
    }
    
    public function getLog() : array
    {
        return $this->log;
    }
}
