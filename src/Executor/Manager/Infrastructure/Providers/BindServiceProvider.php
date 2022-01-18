<?php

namespace Executor\Manager\Infrastructure\Providers;

use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Infrastructure\Persistence\Repositories\GoogleSheetExternalCommandRepository;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(ExternalCommandRepositoryInterface::class, GoogleSheetExternalCommandRepository::class);
    }
}
