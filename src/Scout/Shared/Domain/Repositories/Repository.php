<?php


namespace Scout\Shared\Domain\Repositories;

use Illuminate\Support\Collection;
use Shared\Domain\ValueObject\Id;

interface Repository
{
    public function getAll() : Collection;
    
    public function find(Id $id) : mixed;
}
