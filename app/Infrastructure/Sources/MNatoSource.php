<?php


namespace App\Infrastructure\Sources;


use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use Illuminate\Support\Collection;

class MNatoSource extends CrawlerSource implements MangaSource
{
    public const TYPE = 2;
    
    public function getLastChapter(SourcedVariation $manga): string
    {
        $crawler = $this->client->request('GET', $this->getUri($manga));
        $text = $crawler->filter('.row-content-chapter a')->first()->attr('href');
        return Collection::make(explode('-', $text))->last();
    }
}
