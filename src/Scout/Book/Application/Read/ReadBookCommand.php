<?php

namespace Scout\Book\Application\Read;

use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\LastChapterRead;
use Shared\Domain\Bus\CommandInterface;

class ReadBookCommand implements CommandInterface
{
    private int $id;
    private ?string $readUpto;
    
    public function __construct(int $id, string $readUpto = null)
    {
        $this->id       = $id;
        $this->readUpto = $readUpto;
    }
    
    public function getId(): Id
    {
        return new Id($this->id);
    }
    
    public function getReadUpto(): ?LastChapterRead
    {
        return $this->readUpto !== null ? new LastChapterRead($this->readUpto) : null;
    }
}
