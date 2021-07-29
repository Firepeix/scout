<?php


namespace Lancelot\Pulse\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(BindServiceProvider::class);
        $this->app->register(BusServiceProvider::class);
        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }
}
