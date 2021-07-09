<?php

namespace Shared\Domain\ValueObject;

abstract class BoolValueObject
{
    protected ?bool $value;

    public function __construct(?bool $value)
    {
        $this->value = $value;
    }

    public function value(): ?bool
    {
        return $this->value;
    }
}
