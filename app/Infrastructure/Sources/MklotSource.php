<?php


namespace App\Infrastructure\Sources;


use Illuminate\Support\Collection;
use Scout\Source\Domain\SourcedObject;

class MklotSource extends CrawlerSource
{
    public const TYPE = 1;
    
    public function getLastUpdate(SourcedObject $object): string
    {
        $crawler = $this->client->request('GET', $this->getUri($object));
        $text = $crawler->filter('.chapter_issue > a')->first()->text();
        return Collection::make(explode(' ', $text))->last() - 1;
    }
    
    public function getFollowedSourcedObjects(): Collection
    {
        return new Collection();
    }
}
