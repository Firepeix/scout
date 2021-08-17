<?php


namespace Scout\Book\Domain\ValueObject;

use Illuminate\Support\Str;
use Shared\Domain\ValueObject\StringValueObject;

final class LastChapterRead extends StringValueObject
{
    public function __construct(string $value = '0')
    {
        parent::__construct($value);
    }
    
    public function read() : self
    {
        $this->value = $this->guessAmountToRead();
        return $this;
    }
    
    private function guessAmountToRead() : string
    {
        $decimals = explode('.', $this->value);
        $digits = Str::length($decimals[1] ?? '') + 1;
        $digit = Str::padRight('1', $digits, '0');
        return (($this->value * $digit) + 1) / $digit;
    }
}
