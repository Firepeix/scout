<?php

namespace Executor\Manager\UI\Console;

use Executor\Manager\Application\Dispatch\DispatchCommands;
use Shared\UI\Console\AbstractCommand;

class ExecuteExternalCommands extends AbstractCommand
{
    protected $signature = 'executor:manager:execute:external-commands';
    
    public function handle() : void
    {
        $this->dispatcher->dispatch(new DispatchCommands());
        $this->info('Sucesso');
    }
}
