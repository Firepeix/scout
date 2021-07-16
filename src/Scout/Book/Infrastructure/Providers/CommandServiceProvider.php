<?php


namespace Scout\Book\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Scout\Book\UI\Console\CheckChaptersCommand;
use Scout\Book\UI\Console\ImportFollowedBooksCommand;

class CommandServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $commands = [
            ImportFollowedBooksCommand::class,
            CheckChaptersCommand::class
        ];
        $this->commands($commands);
    }
}
