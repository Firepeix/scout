<?php


namespace Lancelot\Pulse\Domain\Repositories;

use Illuminate\Support\Collection;

interface PulseRepositoryInterface
{
    public function getActivePulses() : Collection;
}
