<?php


namespace Executor\Manager\Infrastructure\Providers;

use Executor\Manager\UI\Console\ExecuteExternalCommands;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            ExecuteExternalCommands::class
        ];
        $this->commands($commands);
    }
}
