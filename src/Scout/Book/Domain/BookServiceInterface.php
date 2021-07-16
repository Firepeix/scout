<?php


namespace Scout\Book\Domain;


use Closure;
use Illuminate\Support\Collection;
use Scout\Source\Domain\SourceInterface;

interface BookServiceInterface
{
    public function getFollowedBooks(SourceInterface $source) : Collection;
    
    public function checkBooksSync(Collection $books, Closure $onDone): void;
    
    public function checkBooksAsync(Collection $books): void;
    
    public function checkBook(Book $book, SourceInterface $source, Closure $success = null) : void;
}
