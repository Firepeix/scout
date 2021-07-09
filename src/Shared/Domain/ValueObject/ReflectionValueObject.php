<?php

namespace Shared\Domain\ValueObject;

use ReflectionObject;


class ReflectionValueObject
{

    private ValueObject $valueObject;

    public function __construct(ValueObject $valueObject)
    {
        $this->valueObject = $valueObject;
    }

    public function valueObject(): ValueObject
    {
        return $this->valueObject;
    }

    public function hasSameValues(ValueObject $other): bool
    {
        $reflectionObject = new ReflectionObject($other);

        $properties = $reflectionObject->getProperties();

        $properties = $this->makeAccessible($properties);

        foreach ($properties as $property) {
            if (! array_key_exists($property->getName(), $this->map())) {
                return false;
            }

            $objectMapped = $this->map()[$property->getName()];

            if ($property->getValue($other) !== $objectMapped) {
                return false;
            }
        }

        return true;
    }

    private function makeAccessible($properties): array
    {
        foreach ($properties as $property) {
            $property->setAccessible(true);
        }

        return $properties;
    }

    public function map(): array
    {
        $map = [];

        $reflectionObject = new ReflectionObject($this->valueObject());

        $properties = $this->makeAccessible($reflectionObject->getProperties());

        foreach ($properties as $property) {
            $map[$property->getName()] = $property->getValue($this->valueObject());
        }

        return $map;
    }
}
