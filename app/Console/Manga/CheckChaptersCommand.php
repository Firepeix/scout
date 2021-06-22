<?php


namespace App\Console\Manga;


use App\Domain\Manga\Manga;
use App\Domain\Manga\Services\MangaService;
use Illuminate\Console\Command;

class CheckChaptersCommand extends Command
{
    private MangaService $service;
    
    protected $signature = 'manga:check-chapters {id?} {name?}';
    
    public function __construct(MangaService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    
    public function handle() : void
    {
        $mangas = $this->service->chooseManga($this->argument('id'), $this->argument('name'));
        $mangas->each(function (Manga $manga) {
            $decision = $this->service->checkChapter($manga);
            if ($decision->hasNewChapter()) {
                $this->line("O manga <fg=cyan>{$manga->getName()}</> tem o novo capitulo: <fg=green>{$decision->getNewChapter()}</>");
            }
        });
    }
    
}
