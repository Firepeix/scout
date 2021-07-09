<?php

namespace Shared\Domain\ValueObject;

use Illuminate\Support\Arr;


trait Optional
{
    public function optional(array $merged): array
    {
        $optional = [];

        foreach ($merged as $key => $value) {
            if (is_null($value)) {
                $optional[] = $key;
            }
        }

        return Arr::except($merged, $optional);
    }
}
