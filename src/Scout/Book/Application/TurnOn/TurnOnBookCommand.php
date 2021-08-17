<?php

namespace Scout\Book\Application\TurnOn;

use Scout\Book\Domain\ValueObject\Id;
use Shared\Domain\Bus\CommandInterface;

class TurnOnBookCommand implements CommandInterface
{
    private int $id;
    
    public function __construct(int $id)
    {
        $this->id           = $id;
    }
    
    public function getId(): Id
    {
        return new Id($this->id);
    }
}
