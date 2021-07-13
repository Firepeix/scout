<?php


namespace App\Domain\Manga;


use Illuminate\Support\Collection;

interface Manga
{
    public function init(string $name, string $lastReadChapter, Collection $sourcedVariations);
    
    public function getName() : string;
    
    public function getLastReadChapter() : string;
    
    public function getSourcedVariations(): Collection;
    
    public function toArray() : array;
}
