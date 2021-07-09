<?php


namespace MangaDex\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(BusServiceProvider::class);
        $this->app->register(BindServiceProvider::class);
    }
}
