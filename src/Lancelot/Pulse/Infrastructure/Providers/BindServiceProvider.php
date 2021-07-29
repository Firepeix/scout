<?php


namespace Lancelot\Pulse\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Pulse\Domain\Repositories\PulseRepositoryInterface;
use Lancelot\Pulse\Domain\Services\PulseService;
use Lancelot\Pulse\Domain\Services\PulseServiceInterface;
use Lancelot\Pulse\Infrastructure\Persistence\Repositories\PulseMetabaseRepository;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(PulseServiceInterface::class, PulseService::class);
        $this->app->bind(PulseRepositoryInterface::class, PulseMetabaseRepository::class);
    }
}
