<?php


namespace App\Application\Manga\Events\Check;


use App\Application\Manga\ChapterCheckDecision;
use App\Domain\Manga\Manga;
use Illuminate\Support\Facades\Event;

class MangaWasChecked extends Event
{
    private Manga                $manga;
    private ChapterCheckDecision $decision;
    
    public function __construct(Manga $manga, ChapterCheckDecision $decision)
    {
        $this->manga    = $manga;
        $this->decision = $decision;
    }
    

   public function getManga(): Manga
    {
        return $this->manga;
    }
    
    public function getDecision(): ChapterCheckDecision
    {
        return $this->decision;
    }
}
