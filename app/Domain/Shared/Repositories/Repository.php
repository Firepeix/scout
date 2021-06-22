<?php


namespace App\Domain\Shared\Repositories;


use Illuminate\Support\Collection;

interface Repository
{
    public function getAll() : Collection;
    
    public function find(string $id) : mixed;
}
