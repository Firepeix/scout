<?php


namespace App\Infrastructure\Providers;


use App\Application\Notification\TextMessage;
use App\Domain\Notification\Services\NotificationService;
use App\Domain\Notification\TextMessage as TextMessageContract;
use App\Infrastructure\Notification\TelegramNotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->bind(NotificationService::class, TelegramNotificationService::class);
        $this->app->bind(TextMessageContract::class, TextMessage::class);
    }
}
