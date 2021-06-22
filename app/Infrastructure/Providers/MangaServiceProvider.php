<?php

namespace App\Infrastructure\Providers;

use App\Application\Manga\Manga;
use App\Application\Manga\Services\MangaService;
use App\Application\Manga\SourcedManga;
use App\Domain\Manga\Manga as MangaContract;
use App\Domain\Manga\Repositories\MangaRepository as MangaRepositoryContract;
use App\Domain\Manga\Services\MangaService as MangaServiceContract;
use App\Domain\Manga\SourcedVariation;
use App\Infrastructure\Persistence\Repositories\Mangas\MangaRepository;
use Illuminate\Support\ServiceProvider;

class MangaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MangaServiceContract::class, MangaService::class);
        $this->app->bind(MangaRepositoryContract::class, MangaRepository::class);
        $this->app->bind(SourcedVariation::class, SourcedManga::class);
        $this->app->bind(MangaContract::class, Manga::class);
    }
    
    public function boot()
    {
        //
    }
}
