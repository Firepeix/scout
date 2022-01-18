<?php

namespace Executor\Manager\Infrastructure\Providers;

use Executor\Manager\Application\Execute\ExecuteCommand;
use Executor\Manager\Application\Execute\ExecuteCommandHandler;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            ExecuteCommand::class => ExecuteCommandHandler::class
        ];
        Bus::map($commands);
    }
}
