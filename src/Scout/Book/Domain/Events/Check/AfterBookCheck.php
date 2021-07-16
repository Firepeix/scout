<?php


namespace Scout\Book\Domain\Events\Check;


use Illuminate\Support\Facades\Event;
use Scout\Book\Domain\Book;
use Scout\Book\Domain\ChapterCheckDecision;

class AfterBookCheck extends Event
{
    private Book                 $book;
    private ChapterCheckDecision $decision;
    
    public function __construct(Book $book, ChapterCheckDecision $decision)
    {
        $this->book     = $book;
        $this->decision = $decision;
    }
    
    public function getBook(): Book
    {
        return $this->book;
    }
    
    public function getDecision(): ChapterCheckDecision
    {
        return $this->decision;
    }
}
