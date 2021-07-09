<?php


namespace Scout\Source\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->register(BindServiceProvider::class);
    }
}
