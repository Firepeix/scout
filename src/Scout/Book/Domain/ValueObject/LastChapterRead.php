<?php


namespace Scout\Book\Domain\ValueObject;

use Shared\Domain\ValueObject\StringValueObject;

final class LastChapterRead extends StringValueObject
{
    public function __construct(string $value = '0')
    {
        parent::__construct($value);
    }
}
