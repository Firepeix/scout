<?php


namespace App\Application\Manga\Services;


use App\Application\Manga\ChapterCheckDecision;
use App\Application\Manga\Events\Check\CheckManga;
use App\Application\Manga\Events\Check\MangaWasChecked;
use App\Domain\Manga\Manga;
use App\Domain\Manga\Repositories\MangaRepository;
use App\Domain\Manga\Services\MangaService as MangaServiceContract;
use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\Repositories\SourceRepository;
use App\Domain\Sources\Source;
use Closure;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;

class MangaService implements MangaServiceContract
{
    private MangaRepository $repository;
    private SourceRepository $sourceRepository;
    private LoggerInterface $logger;
    
    public function __construct(MangaRepository $repository, SourceRepository $sourceRepository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->sourceRepository = $sourceRepository;
        $this->logger = $logger;
    }
    
    public function chooseManga(string $id = null, string $name = null): Collection
    {
        if ($id === null && $name === null) {
            return $this->repository->getAll();
        }
        
        $manga = $this->repository->find($id);
        
        return new Collection([$manga]);
    }
    
    public function checkChapter(Manga $manga): ChapterCheckDecision
    {
        $sources = $this->sourceRepository->getAll();
        $variant = $manga->getSourcedVariations()->first(function (SourcedVariation $variation) use ($sources, $manga){
            return $sources->first(function (Source $source) use ($variation, $manga){
                if ($source->isSource($variation)) {
                    $lastChapter = $source->getLastChapter($variation);
                    $decision = new ChapterCheckDecision($lastChapter, $manga->getLastReadChapter());
                    $this->logger->info('Manga Checado', ['Manga' => $manga->toArray(), 'Source' => $source->toArray(), 'Variation' => $variation->toArray(), 'Decision' => $decision->toArray(), 'Event' => CheckManga::NAME]);
                    $variation->addDecision($decision);
                    return $variation->getDecision()->hasNewChapter();
                }
                
                return false;
            });
        });
        
        if ($variant !== null) {
            return $variant->getDecision();
        }
        return new ChapterCheckDecision('NONE', $manga->getLastReadChapter());
    }
    
    public function checkManga(Manga $manga, Closure $success = null)
    {
        $decision = $this->checkChapter($manga);
        if ($success !== null) {
            $success($manga, $decision);
        }
        event(new MangaWasChecked($manga, $decision));
    }
    
    public function checkMangasSync(Collection $mangas, Closure $success): void
    {
        $mangas->each(function (Manga $manga) use ($success){
            $this->checkManga($manga, $success);
        });
    }
    
    public function checkMangasAsync(Collection $mangas): void
    {
        $mangas->each(function (Manga $manga) {
            event(new CheckManga($manga));
        });
    }
    
    
}
