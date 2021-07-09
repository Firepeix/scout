<?php

namespace Shared\Domain\ValueObject;


abstract class FloatValueObject
{
    protected ?float $value;

    public function __construct(?float $value)
    {
        $this->value = $value;
    }

    public function value(): ?float
    {
        return $this->value;
    }

    public function equals(FloatValueObject $object): bool
    {
        return $this->value() === $object->value();
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}
