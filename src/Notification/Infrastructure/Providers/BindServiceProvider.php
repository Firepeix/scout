<?php


namespace Notification\Infrastructure\Providers;


use Illuminate\Support\ServiceProvider;
use Notification\Domain\Services\NotificationService;
use Notification\Domain\Services\TelegramNotificationService;

class BindServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(NotificationService::class, TelegramNotificationService::class);
    }
}
