<?php


namespace Lancelot\Log\Application\Create;

use Shared\Domain\Bus\CommandInterface;

class CreateLogCommand implements CommandInterface
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
