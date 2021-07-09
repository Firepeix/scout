<?php


namespace Scout\Book\Domain;


use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;

class Book
{
    private Id $id;
    private SourceType $sourceType;
    private Title $title;
    
    public function __construct(Id $id, SourceType $sourceType, Title $title)
    {
        $this->id         = $id;
        $this->sourceType = $sourceType;
        $this->title      = $title;
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
}
