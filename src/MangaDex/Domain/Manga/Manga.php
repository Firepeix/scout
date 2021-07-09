<?php


namespace MangaDex\Domain\Manga;


use App\Infrastructure\Sources\MangaDexSource;
use MangaDex\Domain\Manga\ValueObject\Id;
use MangaDex\Domain\Manga\ValueObject\Title;
use Scout\Source\Domain\SourcedObject;
use Scout\Source\Domain\ValueObject\Type;
use Shared\Domain\ValueObject\StringValueObject;

class Manga implements SourcedObject
{
    private Id    $id;
    private Title $title;
    
    public function __construct(array $content)
    {
        $this->id = new Id($content['data']['id']);
        $this->title = new Title($content['data']['attributes']['title']['en']);
    }
    
    public function getType(): Type
    {
        return new Type(MangaDexSource::TYPE);
    }
    
    public function getExternalId(): Id
    {
        return $this->id;
    }
    
    public function getName(): StringValueObject
    {
        return $this->title;
    }
}
