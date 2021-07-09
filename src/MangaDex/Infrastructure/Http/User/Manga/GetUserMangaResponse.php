<?php


namespace MangaDex\Infrastructure\Http\User\Manga;


use Illuminate\Support\Collection;
use MangaDex\Domain\Manga\Manga;

class GetUserMangaResponse
{
    private Collection $mangas;
    private int $totalAvailable;
    
    public function __construct(array $content)
    {
        $this->mangas = new Collection();
        $this->createMangas($content['results']);
        $this->totalAvailable = $content['total'];
    }
    
    private function createMangas(array $mangas) : void
    {
        $this->mangas = new Collection();
        foreach ($mangas as $manga) {
            $this->mangas->push(new Manga($manga));
        }
    }
    
    public function getMangas() : Collection
    {
        return $this->mangas;
    }
    
    public function getTotalAvailable(): int
    {
        return $this->totalAvailable;
    }
}
