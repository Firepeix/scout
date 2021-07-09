<?php


namespace Scout\Book\Domain\Services;


use Illuminate\Support\Collection;
use Scout\Book\Domain\Book;
use Scout\Book\Domain\BookServiceInterface;
use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\SourceType;
use Scout\Book\Domain\ValueObject\Title;
use Scout\Source\Domain\SourcedObject;
use Scout\Source\Domain\SourceInterface;

class BookService implements BookServiceInterface
{
    public function getFollowedBooks(SourceInterface $source): Collection
    {
        return $source->getFollowedSourcedObjects()->map(function (SourcedObject $object) {
            $id = new Id($object->getExternalId()->value());
            $title = new Title($object->getName()->value());
            $type = new SourceType($object->getType()->value());
            return new Book($id, $type, $title);
        });
    }
}
