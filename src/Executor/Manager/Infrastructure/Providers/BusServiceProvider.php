<?php

namespace Executor\Manager\Infrastructure\Providers;

use Executor\Manager\Application\Execute\ExecuteCommand;
use Executor\Manager\Application\Execute\ExecuteCommandHandler;
use Shared\Infrastructure\Providers\AbstractBusServiceProvider;

class BusServiceProvider extends AbstractBusServiceProvider
{
    protected array $commands = [
        ExecuteCommand::class => ExecuteCommandHandler::class
    ];
}
