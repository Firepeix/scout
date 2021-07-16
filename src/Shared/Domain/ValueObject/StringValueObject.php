<?php

namespace Shared\Domain\ValueObject;


use JsonSerializable;

abstract class StringValueObject implements JsonSerializable
{
    protected ?string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function equals(StringValueObject $object): bool
    {
        return $this->value() === $object->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }
    
    public function jsonSerialize() : string
    {
        return $this;
    }
}
