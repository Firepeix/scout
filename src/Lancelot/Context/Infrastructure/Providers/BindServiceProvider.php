<?php

namespace Lancelot\Context\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Context\Domain\Repositories\ContextRepositoryInterface;
use Lancelot\Context\Infrastructure\Persistence\Repositories\ContextMetabaseRepository;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(ContextRepositoryInterface::class, ContextMetabaseRepository::class);
    }
}
