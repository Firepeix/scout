<?php


namespace App\Infrastructure\Sources;


use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use Illuminate\Support\Collection;

class MklotSource extends CrawlerSource implements MangaSource
{
    public const TYPE = 1;
    
    public function getLastChapter(SourcedVariation $manga): string
    {
        $crawler = $this->client->request('GET', $this->getUri($manga));
        $text = $crawler->filter('.chapter_issue > a')->first()->text();
        return Collection::make(explode(' ', $text))->last() - 1;
    }
}
