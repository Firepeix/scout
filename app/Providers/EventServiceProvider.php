<?php

namespace App\Providers;

use App\Application\Manga\Listeners\Check\CheckMangaHandler;
use App\Application\Manga\Listeners\Check\NewChapterSendNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Scout\Book\Domain\Events\Check\AfterBookCheck;
use Scout\Book\Domain\Events\Check\CheckBook;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CheckBook::class       => [CheckMangaHandler::class],
        AfterBookCheck::class => [NewChapterSendNotification::class]
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
