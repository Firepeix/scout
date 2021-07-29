<?php


namespace Lancelot\Pulse\Domain\Services;


use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\Pulse;

class PulseService implements PulseServiceInterface
{
    public function fire(Collection $pulses): void
    {
        $pulses->each(function (Pulse $pulse) {
            if ($pulse->shouldFire()) {
                dd(3);
            }
        });
    }
}
