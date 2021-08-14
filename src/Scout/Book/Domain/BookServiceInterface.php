<?php

namespace Scout\Book\Domain;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;
use Scout\Source\Domain\SourceInterface;

interface BookServiceInterface
{
    public function getFollowedBooks(SourceInterface $source): Collection;
    
    public function checkBooksSync(Collection $books, Closure $onDone): void;
    
    public function checkBooksAsync(Collection $books): void;
    
    public function checkBook(Book $book, SourceInterface $source, Closure $success = null): void;
    
    public function postponeBook(Book $book, Carbon $until): void;
}
