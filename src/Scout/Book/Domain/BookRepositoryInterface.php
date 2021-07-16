<?php


namespace Scout\Book\Domain;


use Illuminate\Support\Collection;
use Scout\Shared\Domain\Repositories\Repository;

interface BookRepositoryInterface extends Repository
{
    public function insert(Collection $books) : void;
    
    public function getMainBooks(string $id = null, string $name = null): Collection;
}
