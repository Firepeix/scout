<?php


namespace Scout\Book\UI\Api\Routes;


use Scout\Book\UI\Api\Actions\Dashboard\GetBooksDashboard;
use Shared\UI\App\AbstractRoute;

class DashboardRoutes extends AbstractRoute
{
    protected function routes()
    {
        $this->router->group(['prefix' => '/'], function () {
            $this->router->get('/', GetBooksDashboard::class);
        });
    }
    
}
