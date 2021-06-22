<?php

namespace App\Infrastructure\Providers;

use App\Domain\Sources\Repositories\SourceRepository as SourceRepositoryContract;
use App\Infrastructure\Persistence\Repositories\Sources\SourceRepository;
use Illuminate\Support\ServiceProvider;

class SourceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SourceRepositoryContract::class, SourceRepository::class);
    }

    public function boot()
    {
        //
    }
}
