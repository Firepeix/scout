<?php

namespace Lancelot\Pulse\Domain\ValueObject;

use Shared\Domain\ValueObject\BoolValueObject;

class AlertAboveGoal extends BoolValueObject
{
    public function __construct(bool $value = false)
    {
        parent::__construct($value);
    }
}
