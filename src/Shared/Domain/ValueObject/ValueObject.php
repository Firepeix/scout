<?php

namespace Shared\Domain\ValueObject;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;


abstract class ValueObject implements Arrayable
{

    public function equals(ValueObject $other): bool
    {
        $reflectionObject = new ReflectionValueObject($this);

        return $reflectionObject->hasSameValues($other);
    }


    public function toArray(): array
    {
        $converted = [];

        $reflectionObject = new ReflectionValueObject($this);

        $map = $reflectionObject->map();

        foreach (array_keys($map) as $key) {
            $converted[Str::snake($key)] = $map[$key];
        }

        return $converted;
    }
}
