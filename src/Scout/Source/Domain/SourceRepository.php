<?php


namespace Scout\Source\Domain;


use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Shared\Domain\Repositories\Repository;

interface SourceRepository extends Repository
{
    public function findSourceByType(SourceType $sourceType) : SourceInterface;
}
