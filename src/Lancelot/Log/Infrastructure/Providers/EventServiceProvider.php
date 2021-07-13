<?php

namespace Lancelot\Log\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;
use Lancelot\Log\Infrastructure\Listeners\SendAlertToTelegramNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AlertErrorsOverflowed::class => [SendAlertToTelegramNotification::class],
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
