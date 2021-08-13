<?php


namespace Scout\Book\Infrastructure\Providers;


use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Scout\Book\Application\Check\CheckChaptersCommand;
use Scout\Book\Application\Check\CheckChaptersCommandHandler;
use Scout\Book\Application\Get\GetBooksCommand;
use Scout\Book\Application\Get\GetBooksCommandHandler;
use Scout\Book\Application\Import\ImportFollowedCommand;
use Scout\Book\Application\Import\ImportFollowedCommandHandler;

class BusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerHandlers();
    }
    
    private function registerHandlers()
    {
        $commands = [
            CheckChaptersCommand::class  => CheckChaptersCommandHandler::class,
            GetBooksCommand::class       => GetBooksCommandHandler::class,
            ImportFollowedCommand::class => ImportFollowedCommandHandler::class
        ];
        Bus::map($commands);
    }
}
