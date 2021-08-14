<?php

namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Collection;
use Lancelot\Log\UI\Api\Routes\LogRoutes;
use Shared\UI\App\AbstractRoute;

class RouteServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $routes = new Collection([
            new LogRoutes()
        ]);
        
        $routes->each(fn (AbstractRoute $route) => $route->register());
    }
}
