<?php


namespace App\Infrastructure\Persistence\Repositories\Mangas;

use App\Domain\Manga\Manga as MangaContract;
use App\Domain\Manga\Repositories\MangaRepository as MangaRepositoryContract;
use App\Domain\Manga\SourcedVariation;
use App\Infrastructure\Persistence\Models\Mangas\Manga as MangaModel;
use App\Infrastructure\Persistence\Repositories\AbstractRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Revolution\Google\Sheets\Contracts\Factory;

class GoogleSheetMangaRepository extends AbstractRepository implements MangaRepositoryContract
{
    private const IGNORE_UNTIL_FIELD = 4;
    
    private Factory $sheet;

    public function __construct(MangaModel $model, Factory $sheet)
    {
        parent::__construct($model);
        $this->sheet = $sheet->spreadsheet(env('SHEET_ID'))->sheet('Main');
    }
    
    public function find(string $id): MangaContract
    {
        $position = (int) $id + 1;
        $manga = $this->sheet->range("A$position:E$position")->get()->first();
        return $this->map($manga);
    }
    
    public function getAll(): Collection
    {
        $mangas = $this->sheet->range('A1:E500')->get()->slice(1)->values();
        return $this->filter($mangas)->map(fn ($model) => $this->map($model));
    }
    
    private function filter(Collection $mangas) : Collection
    {
        return $mangas->filter(function (array $manga) {
            return $this->filterIgnored($manga) && !empty($manga);
        });
    }
    
    private function filterIgnored(array $manga) : bool
    {
        if (isset($manga[self::IGNORE_UNTIL_FIELD])) {
            $ignoreUntil = Carbon::parse($manga[self::IGNORE_UNTIL_FIELD]);
            return $ignoreUntil->isPast();
        }
        
        return true;
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
