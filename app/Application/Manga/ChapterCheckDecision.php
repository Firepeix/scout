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
        return $this->chapterFound !== 'NONE' && $this->chapterFound !== $this->lastReadChapter;
    }
    
    public function getNewChapter() : string
    {
        return $this->chapterFound;
    }
    
    public function toArray() : array
    {
        return [
            'chapterFound' => $this->chapterFound,
            'lastReadChapter' => $this->lastReadChapter
        ];
    }
}
