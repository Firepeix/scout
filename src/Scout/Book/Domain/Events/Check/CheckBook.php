<?php


namespace Scout\Book\Domain\Events\Check;

use Illuminate\Support\Facades\Event;
use Scout\Book\Domain\Book;

class CheckBook extends Event
{
    public const NAME = 'CheckManga';
    
    private Book $book;
    
    public function __construct(Book $book)
    {
        $this->book = $book;
    }
    
    public function getBook(): Book
    {
        return $this->book;
    }
}
