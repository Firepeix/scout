<?php


namespace Scout\Book\Infrastructure\Providers;


use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Scout\Book\Application\Import\ImportFollowedCommand;
use Scout\Book\Application\Import\ImportFollowedCommandHandler;

class BusServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            ImportFollowedCommand::class => ImportFollowedCommandHandler::class
        ];
        Bus::map($commands);
    }
}
