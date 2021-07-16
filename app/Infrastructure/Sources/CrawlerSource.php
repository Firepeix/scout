<?php


namespace App\Infrastructure\Sources;


use Goutte\Client;
use Illuminate\Support\Str;
use Scout\Source\Domain\ConcreteSourceInterface;
use Scout\Source\Domain\SourcedObject;

abstract class CrawlerSource  extends AbstractSource  implements ConcreteSourceInterface
{
    protected Client $client;
    
    public function __construct(string $template, int $type, string $name)
    {
        parent::__construct($template, $type, $name);
        $this->client = new Client();
    }
    
    protected function getUri(SourcedObject $object) : string
    {
        return Str::replace('${MANGA-ID}', $object->getSourcedId(), $this->template);
    }
}
