<?php

namespace Scout\Book\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Collection;
use Scout\Book\UI\Api\Routes\BookRoutes;
use Scout\Book\UI\Api\Routes\DashboardRoutes;
use Shared\UI\App\AbstractRoute;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';
    
    public function register() : void
    {
        $routes = new Collection([
            new DashboardRoutes(),
            new BookRoutes()
        ]);
        
        $routes->each(fn (AbstractRoute $route) => $route->register());
    }
}
