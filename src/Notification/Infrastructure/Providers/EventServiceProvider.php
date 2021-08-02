<?php

namespace Notification\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Notification\Domain\Events\NewNotification;
use Notification\UI\Listeners\SendNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewNotification::class => [SendNotification::class]
    ];
}
