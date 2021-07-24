<?php

namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;
use Lancelot\Log\Infrastructure\Events\NewLogEvent;
use Lancelot\Log\Infrastructure\Listeners\SendAlertToTelegramNotification;
use Lancelot\Log\UI\Listeners\WriteLog;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        AlertErrorsOverflowed::class => [SendAlertToTelegramNotification::class],
        NewLogEvent::class => [WriteLog::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
