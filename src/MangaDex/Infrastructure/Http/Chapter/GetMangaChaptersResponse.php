<?php


namespace MangaDex\Infrastructure\Http\Chapter;


use Illuminate\Support\Collection;
use MangaDex\Domain\Chapter\Chapter;

class GetMangaChaptersResponse
{
    private Collection $chapters;
    
    public function __construct(array $content)
    {
        $this->chapters = new Collection();
        $this->createChapters($content['results']);
    }
    
    private function createChapters(array $chapters) : void
    {
        $this->chapters = new Collection();
        foreach ($chapters as $chapter) {
            if ($chapter['data']['type'] === Chapter::TYPE) {
                $this->chapters->push(new Chapter($chapter));
            }
        }
    }
    
    public function getLastChapterNumber() : string
    {
        return $this->chapters->isNotEmpty() ? $this->chapters->first()->getNumber() : '';
    }
}
