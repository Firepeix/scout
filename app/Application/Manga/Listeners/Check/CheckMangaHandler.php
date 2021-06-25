<?php


namespace App\Application\Manga\Listeners\Check;


use App\Application\Manga\Events\Check\CheckManga;
use App\Domain\Manga\Services\MangaService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckMangaHandler implements ShouldQueue
{
    private MangaService $service;
    
    public function __construct(MangaService $service)
    {
        $this->service = $service;
    }
    
    public function handle(CheckManga $checkManga) : void
    {
        $this->service->checkManga($checkManga->getManga());
    }
}
