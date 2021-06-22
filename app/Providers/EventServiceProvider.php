<?php

namespace App\Providers;

use App\Events\Homologation\NewBuildEvent;
use App\Listeners\Homologation\StartBuild;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewBuildEvent::class => [
            StartBuild::class,
        ],
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
