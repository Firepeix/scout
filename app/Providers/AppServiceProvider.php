<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (env("APP_ENV") === 'production') {
            $this->app->make('url')->forceRootUrl(env('APP_URL'));
        }
    }

    public function boot()
    {
        //
    }
}
