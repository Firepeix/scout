<?php

namespace Scout\Book\Domain;

use Illuminate\Support\Collection;
use Shared\Domain\ValueObject\Id;

interface BookRepositoryInterface
{
    public function find(Id $id) : Book;
    
    public function insert(Collection $books) : void;
    
    public function getMainBooks(string $id = null, string $name = null, bool $filterIgnored = true): Collection;
    
    public function updateBook(Book $book) : void;
}
