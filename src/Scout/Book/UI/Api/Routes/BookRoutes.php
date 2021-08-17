<?php

namespace Scout\Book\UI\Api\Routes;

use Scout\Book\UI\Api\Actions\Book\PostponeBookAction;
use Scout\Book\UI\Api\Actions\Book\ReadBookAction;
use Scout\Book\UI\Api\Actions\Book\TurnOnBookAction;
use Shared\UI\App\AbstractRoute;

class BookRoutes extends AbstractRoute
{
    protected function routes()
    {
        $this->router->group(['prefix' => '/books'], function () {
            $this->router->put('{id}/postpone', PostponeBookAction::class);
            $this->router->put('{id}/turn-on', TurnOnBookAction::class);
            $this->router->put('{id}/read', ReadBookAction::class);
        });
    }
    
}
