<?php

namespace Scout\Book\UI\Api\Routes;

use Scout\Book\UI\Api\Actions\Book\PostponeBookAction;
use Shared\UI\App\AbstractRoute;

class BookRoutes extends AbstractRoute
{
    protected function routes()
    {
        $this->router->group(['prefix' => '/books'], function () {
            $this->router->put('{id}/postpone', PostponeBookAction::class);
        });
    }
    
}
