<?php


namespace Scout\Book\Application\Get;


use Illuminate\Support\Collection;
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
     * @return Collection<Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }
}
