<?php


namespace App\Infrastructure\Persistence\Repositories\Mangas;

use App\Domain\Manga\Manga as MangaContract;
use App\Domain\Manga\Repositories\MangaRepository as MangaRepositoryContract;
use App\Domain\Manga\SourcedVariation;
use App\Infrastructure\Persistence\Models\Mangas\Manga as MangaModel;
use App\Infrastructure\Persistence\Repositories\AbstractRepository;
use Exception;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;

class GoogleSheetMangaRepository extends AbstractRepository implements MangaRepositoryContract
{
    private Factory $sheet;

    public function __construct(MangaModel $model, Factory $sheet)
    {
        parent::__construct($model);
        $this->sheet = $sheet->spreadsheet(env('SHEET_ID'))->sheet('Main');
    }
    
    public function find(string $id): MangaContract
    {
        throw new Exception('Não implementado');
    }
    
    public function getAll(): Collection
    {
        $mangas = $this->sheet->range('A1:D100')->get()->slice(1)->values();
        return $mangas->map(fn ($model) => $this->map($model));
    }
    
    protected function map($model) : MangaContract
    {
        $sources = json_decode($model[3], true);
        $sourcedVariations = Collection::make($sources)->map(fn (array $source) => $this->mapSourcedManga($source));
        $manga = app(MangaContract::class);
        $manga->init($model[1], $model[2], $sourcedVariations);
        return $manga;
    }
    
    private function mapSourcedManga(array $source) : SourcedVariation
    {
        $sourced = app(SourcedVariation::class);
        $sourced->init(...$source);
        return $sourced;
    }
}
