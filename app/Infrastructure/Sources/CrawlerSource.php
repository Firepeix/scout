<?php


namespace App\Infrastructure\Sources;


use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\MangaSource;
use Goutte\Client;
use Illuminate\Support\Str;

abstract class CrawlerSource  extends AbstractSource implements MangaSource
{
    protected Client $client;
    
    public function __construct(string $template, int $type, string $name)
    {
        parent::__construct($template, $type, $name);
        $this->client = new Client();
    }
    
    protected function getUri(SourcedVariation $manga) : string
    {
        return Str::replace('${MANGA-ID}', $manga->getExternalId(), $this->template);
    }
}
