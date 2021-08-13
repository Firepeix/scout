<?php


namespace Scout\Book\Application\Get;
use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\Title;
use Shared\Domain\Bus\CommandInterface;

class GetBooksCommand implements CommandInterface
{
    private ? Id $id;
    private ? Title $title;
    private bool $includeIgnored;
    
    public function __construct(?Id $id = null, ?Title $title = null, bool $includeIgnored = false)
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->includeIgnored = $includeIgnored;
    }
    
    public function getId(): ?Id
    {
        return $this->id;
    }
    
    public function getTitle(): ?Title
    {
        return $this->title;
    }

    public function includeIgnored(): bool
    {
        return $this->includeIgnored;
    }
}
