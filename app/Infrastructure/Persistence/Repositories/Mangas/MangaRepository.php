<?php


namespace App\Infrastructure\Persistence\Repositories\Mangas;

use App\Domain\Manga\Manga as MangaContract;
use App\Domain\Manga\Repositories\MangaRepository as MangaRepositoryContract;
use App\Domain\Manga\SourcedVariation;
use App\Infrastructure\Persistence\Models\Mangas\Manga as MangaModel;
use App\Infrastructure\Persistence\Repositories\AbstractRepository;
use Illuminate\Support\Collection;

class MangaRepository extends AbstractRepository implements MangaRepositoryContract
{
    public function __construct(MangaModel $model)
    {
        parent::__construct($model);
    }
    
    public function find(string $id): MangaContract
    {
        return parent::find($id);
    }
    
    public function getAll(): Collection
    {
        return parent::getAll();
    }
    
    protected function map($model) : MangaContract
    {
        $sourcedVariations = Collection::make($model->sources)->map(fn (array $source) => $this->mapSourcedManga($source));
        $manga = app(MangaContract::class);
        $manga->init($model->name, $model->last_read_chapter, $sourcedVariations);
        return $manga;
    }
    
    private function mapSourcedManga(array $source) : SourcedVariation
    {
        $sourced = app(SourcedVariation::class);
        $sourced->init($source['type'], $source['external_id']);
        return $sourced;
    }
}
