<?php


namespace Scout\Book\Domain;


use Illuminate\Support\Collection;
use Scout\Source\Domain\SourceInterface;

interface BookServiceInterface
{
    public function getFollowedBooks(SourceInterface $source) : Collection;
}
