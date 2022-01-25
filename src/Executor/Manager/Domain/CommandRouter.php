<?php

namespace Executor\Manager\Domain;

use Illuminate\Support\Collection;
use Shared\Domain\Util\Result\Err;
use Shared\Domain\Util\Result\Ok;
use Shared\Domain\Util\Result\Result;

class CommandRouter
{
    /**
     * @var Collection<string, string>
     */
    private Collection $commands;
    
    public function __construct()
    {
        $this->commands = new Collection();
    }
    
    public function addCommand(string $name, string $class): void
    {
        $this->commands->put($name, $class);
    }
    
    /**
     * @param string $name
     * @return Result<string>
     */
    public function getCommand(string $name) : Result
    {
        if (isset($this->commands[$name])) {
            return new Ok($this->commands[$name]);
        }
        
        return new Err("Command Not Found");
    }
}
