<?php


namespace App\Application\Manga;


class ChapterCheckDecision
{
    private string $chapterFound;
    
    private string $lastReadChapter;
    
    public function __construct(string $chapterFound, string $lastReadChapter)
    {
        $this->chapterFound    = $chapterFound;
        $this->lastReadChapter = $lastReadChapter;
    }
    
    public function hasNewChapter() : bool
    {
        $chapter = is_numeric($this->chapterFound) ? $this->chapterFound - 1 : $this->chapterFound;
        return $this->chapterFound !== 'NONE' && (string) $chapter !== $this->lastReadChapter;
    }
    
    public function getNewChapter() : string
    {
        return is_numeric($this->chapterFound) ? $this->chapterFound - 1 : $this->chapterFound;
    }
}
