<?php

namespace Scout\Book\Infrastructure\Providers;

use Scout\Book\UI\Api\Book\GetBooksAction;
use Scout\Book\UI\Api\Book\PostponeBookAction;
use Scout\Book\UI\Api\Book\ReadBookAction;
use Scout\Book\UI\Api\Book\TurnOnBookAction;
use Scout\Book\UI\Api\Dashboard\GetBooksDashboard;
use Shared\Infrastructure\Providers\RouteServiceProvider as BaseRouteProvider;

class RouteServiceProvider extends BaseRouteProvider
{
    protected array $actions = [
        GetBooksDashboard::class,
        PostponeBookAction::class,
        TurnOnBookAction::class,
        ReadBookAction::class,
        GetBooksAction::class
    ];
}
