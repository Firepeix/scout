<?php

namespace Lancelot\Pulse\Domain\Services;

use Illuminate\Support\Collection;

interface PulseServiceInterface
{
    public function fire(Collection $pulses) : void;
}
