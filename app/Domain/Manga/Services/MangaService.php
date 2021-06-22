<?php


namespace App\Domain\Manga\Services;


use App\Application\Manga\ChapterCheckDecision;
use App\Domain\Manga\Manga;
use Illuminate\Support\Collection;

interface MangaService
{
    public function chooseManga(string $id = null, string $name = null) : Collection;
    
    public function checkChapter(Manga $manga) : ChapterCheckDecision;
}
