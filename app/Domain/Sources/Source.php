<?php


namespace App\Domain\Sources;

use App\Domain\Manga\SourcedVariation;

interface Source
{
    public function isSource(SourcedVariation $variation) : bool;
    
    public function getLastChapter(SourcedVariation $manga) : string;
    
    public function toArray() : array;
}
