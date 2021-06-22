<?php


namespace App\Domain\Manga;

use App\Application\Manga\ChapterCheckDecision;

interface SourcedVariation
{
    public function init(int $type, string $externalId) : void;
    
    public function getType() : int;
    
    public function getDecision() : ? ChapterCheckDecision;
    
    public function addDecision(ChapterCheckDecision $decision) : void;
    
    public function getExternalId() : string;
}
