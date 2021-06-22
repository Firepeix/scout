<?php


namespace App\Domain\Manga\Repositories;


use App\Domain\Manga\Manga;
use App\Domain\Shared\Repositories\Repository;

interface MangaRepository extends Repository
{
    public function find(string $id): Manga;
}
