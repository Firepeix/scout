<?php

namespace App\Providers;

use App\Application\Manga\Events\Check\CheckManga;
use App\Application\Manga\Events\Check\MangaWasChecked;
use App\Application\Manga\Listeners\Check\CheckMangaHandler;
use App\Application\Manga\Listeners\Check\NewChapterSendNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CheckManga::class => [CheckMangaHandler::class],
        MangaWasChecked::class => [NewChapterSendNotification::class]
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
