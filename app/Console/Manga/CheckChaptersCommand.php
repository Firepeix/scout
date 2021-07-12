<?php


namespace App\Console\Manga;


use App\Application\Manga\ChapterCheckDecision;
use App\Domain\Manga\Manga;
use App\Domain\Manga\Services\MangaService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CheckChaptersCommand extends Command
{
    private MangaService $service;
    
    protected $signature = 'manga:check-chapters {id?} {name?} {--batch=0} {--batch-size=10} {--async}';
    
    public function __construct(MangaService $service)
    {
        parent::__construct();
        $this->service = $service;
    }
    
    public function handle() : void
    {
        if ($this->argument('id') === '1') {
            Log::info(2);
            return;
        }
        $mangas = $this->service->chooseManga($this->argument('id'), $this->argument('name'));
        $mangas = $mangas->chunk($this->option('batch-size'))[$this->option('batch')] ?? new Collection();
        $success = function (Manga $manga, ChapterCheckDecision $decision) {
            if ($decision->hasNewChapter()) {
                $this->line("O manga <fg=cyan>{$manga->getName()}</> tem o novo capitulo: <fg=green>{$decision->getNewChapter()}</>");
            }
        };
        
        if ($this->option('async')) {
            $this->service->checkMangasAsync($mangas);
            return;
        }
        $this->service->checkMangasSync($mangas, $success);
    }
    
}
