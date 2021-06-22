<?php


namespace App\Infrastructure\Sources;


use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use Goutte\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MklotSource extends AbstractSource implements MangaSource
{
    public const TYPE = 1;
    
    private Client $client;
    
    public function __construct(string $template, int $type)
    {
        parent::__construct($template, $type);
        $this->client = new Client();
    }
    
    public function getLastChapter(SourcedVariation $manga): string
    {
        $uri = Str::replace('${MANGA-ID}', $manga->getExternalId(), $this->template);
        try {
            $crawler = $this->client->request('GET', $uri);
            $text = $crawler->filter('.chapter_issue > a')->first()->text();
            return Collection::make(explode(' ', $text))->last();
        }catch (\Exception $exception) {
            return 'NONE';
        }
    }
}
