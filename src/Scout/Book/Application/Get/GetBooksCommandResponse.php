<?php


namespace Scout\Book\Application\Get;


use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;
use Scout\Book\Domain\Book;
use Shared\Domain\Bus\CommandResponseInterface;

class GetBooksCommandResponse implements CommandResponseInterface
{
    /**
     * @var Collection<Book>
     */
    private Collection $books;
    
    public function __construct($books)
    {
        $this->books = $books;
    }
    
    /**
     * @return array<Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }
    
    /**
     * @return array<Book>
     */
    #[Pure]
    public function getData(): array
    {
        return $this->getBooks()->toArray();
    }
}
