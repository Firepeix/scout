<?php


namespace App\Domain\Manga\Services;


use App\Application\Manga\ChapterCheckDecision;
use App\Domain\Manga\Manga;
use Closure;
use Illuminate\Support\Collection;

interface MangaService
{
    public function chooseManga(string $id = null, string $name = null) : Collection;
    
    public function checkChapter(Manga $manga) : ChapterCheckDecision;
    
    public function checkManga(Manga $manga, Closure $success = null);
    
    public function checkMangasSync(Collection $mangas, Closure $success) : void;
    
    public function checkMangasAsync(Collection $mangas) : void;
}
