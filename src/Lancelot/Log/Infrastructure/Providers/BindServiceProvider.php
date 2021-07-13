<?php


namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Lancelot\Log\Domain\LogRepositoryInterface;
use Lancelot\Log\Domain\LogServiceInterface;
use Lancelot\Log\Domain\Services\LogService;
use Lancelot\Log\Infrastructure\Persistence\LogRepository;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
        $this->app->bind(LogServiceInterface::class, LogService::class);
    }
}
