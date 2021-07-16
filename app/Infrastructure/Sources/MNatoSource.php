<?php


namespace App\Infrastructure\Sources;


use Illuminate\Support\Collection;
use Scout\Source\Domain\SourcedObject;

class MNatoSource extends CrawlerSource
{
    public const TYPE = 2;
    
    public function getLastUpdate(SourcedObject $object): string
    {
        $crawler = $this->client->request('GET', $this->getUri($object));
        $text = $crawler->filter('.row-content-chapter a')->first()->attr('href');
        return Collection::make(explode('-', $text))->last();
    }
    
    public function getFollowedSourcedObjects(): Collection
    {
        return new Collection();
    }
    
    
}
