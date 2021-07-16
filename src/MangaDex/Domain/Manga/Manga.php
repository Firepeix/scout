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
    
    public function getSourcedType(): Type
    {
        return new Type(MangaDexSource::TYPE);
    }
    
    public function getSourcedId(): Id
    {
        return $this->id;
    }
    
    public function getSourcedName(): StringValueObject
    {
        return $this->title;
    }
}
