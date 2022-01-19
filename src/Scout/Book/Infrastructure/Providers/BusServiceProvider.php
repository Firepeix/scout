<?php


namespace Scout\Book\Infrastructure\Providers;


use Scout\Book\Application\Check\CheckChaptersCommand;
use Scout\Book\Application\Check\CheckChaptersCommandHandler;
use Scout\Book\Application\Get\GetBooksCommand;
use Scout\Book\Application\Get\GetBooksCommandHandler;
use Scout\Book\Application\Import\ImportFollowedCommand;
use Scout\Book\Application\Import\ImportFollowedCommandHandler;
use Scout\Book\Application\Postpone\PostponeBookCommand;
use Scout\Book\Application\Postpone\PostponeBookCommandHandler;
use Scout\Book\Application\Read\ReadBookCommand;
use Scout\Book\Application\Read\ReadBookCommandHandler;
use Scout\Book\Application\TurnOn\TurnOnBookCommand;
use Scout\Book\Application\TurnOn\TurnOnCommandHandler;
use Shared\Infrastructure\Providers\AbstractBusServiceProvider;

class BusServiceProvider extends AbstractBusServiceProvider
{
    protected array $commands = [
        CheckChaptersCommand::class  => CheckChaptersCommandHandler::class,
        GetBooksCommand::class       => GetBooksCommandHandler::class,
        ImportFollowedCommand::class => ImportFollowedCommandHandler::class,
        PostponeBookCommand::class   => PostponeBookCommandHandler::class,
        TurnOnBookCommand::class     => TurnOnCommandHandler::class,
        ReadBookCommand::class => ReadBookCommandHandler::class
    ];
}
