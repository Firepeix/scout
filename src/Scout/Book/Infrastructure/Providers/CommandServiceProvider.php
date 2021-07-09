<?php


namespace Scout\Book\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Scout\Book\UI\Console\ImportFollowedBooksCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            ImportFollowedBooksCommand::class
        ];
        $this->commands($commands);
    }
}
