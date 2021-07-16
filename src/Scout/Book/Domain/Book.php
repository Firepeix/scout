<?php


namespace Scout\Book\Domain;


use Scout\Book\Domain\ValueObject\ExternalId;
use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\LastChapterRead;
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;
use Scout\Source\Domain\SourcedObject;
use Scout\Source\Domain\ValueObject\Type;
use Shared\Domain\ValueObject\Id as SourcedId;
use Shared\Domain\ValueObject\StringValueObject;

class Book implements SourcedObject
{
    private ? Id              $id;
    private Title           $title;
    private LastChapterRead $lastChapterRead;
    private ExternalId      $externalId;
    private SourceType      $sourceType;
    
    public function __construct(? Id $id, Title $title, LastChapterRead $lastChapterRead, ExternalId $externalId, SourceType $sourceType)
    {
        $this->id              = $id;
        $this->title           = $title;
        $this->lastChapterRead = $lastChapterRead;
        $this->externalId      = $externalId;
        $this->sourceType      = $sourceType;
    }
    
    public function getId(): Id
    {
        return $this->id;
    }
    
    public function getSourceType(): SourceType
    {
        return $this->sourceType;
    }
    
    public function getTitle(): Title
    {
        return $this->title;
    }
    
    public function getSourcedType(): Type
    {
        return new Type($this->sourceType->value());
    }
    
    public function getSourcedId(): SourcedId
    {
        return $this->externalId;
    }
    
    public function getSourcedName(): StringValueObject
    {
        return $this->title;
    }
    
    public function getLastChapterRead(): LastChapterRead
    {
        return $this->lastChapterRead;
    }
    
    public function toArray() : array
    {
        return [
            'name' => $this->title->value(),
            'lastReadChapter' => $this->lastChapterRead->value(),
            'externalId' => $this->externalId->value()
        ];
    }
}
