<?php


namespace App\Application\Manga;


use App\Domain\Manga\Manga as MangaContract;
use Illuminate\Support\Collection;

class Manga implements MangaContract
{
    private string $name;
    private string $lastReadChapter;
    private Collection $sourcedVariations;
    
    public function init(string $name, string $lastReadChapter, Collection $sourcedVariations)
    {
        $this->name = $name;
        $this->lastReadChapter = $lastReadChapter;
        $this->sourcedVariations = $sourcedVariations;
    }
    
    public function getName() : string
    {
        return $this->name;
    }
    
    public function getLastReadChapter(): string
    {
        return $this->lastReadChapter;
    }
    
    public function getSourcedVariations(): Collection
    {
        return $this->sourcedVariations;
    }
}
