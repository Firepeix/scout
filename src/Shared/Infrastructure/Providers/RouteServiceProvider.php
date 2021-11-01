<?php

namespace Shared\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use ReflectionClass;
use Shared\Infrastructure\Http\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var array<string>
     */
    protected array $actions = [];
    
    public function register() : void
    {
        $router = $this->app->make(Router::class);
        foreach ($this->actions as $action) {
            $reflection = new ReflectionClass($action);
            $attributes = $reflection->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                $attribute = $attribute->newInstance();
                $router->addRoute([$attribute->getMethod(), 'HEAD'], $attribute->getUrl(), $action)->name($attribute->getName());
            }
        }
    }
}
