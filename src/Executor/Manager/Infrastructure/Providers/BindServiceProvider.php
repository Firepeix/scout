<?php

namespace Executor\Manager\Infrastructure\Providers;

use Executor\Manager\Domain\CommandRouter;
use Executor\Manager\Domain\Repositories\ExternalCommandRepositoryInterface;
use Executor\Manager\Domain\Services\CommandManagerService;
use Executor\Manager\Domain\Services\CommandManagerServiceInterface;
use Executor\Manager\Infrastructure\Persistence\Repositories\GoogleSheetExternalCommandRepository;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton(CommandRouter::class);
        $this->app->bind(ExternalCommandRepositoryInterface::class, GoogleSheetExternalCommandRepository::class);
        $this->app->bind(CommandManagerServiceInterface::class, CommandManagerService::class);
    }
}
