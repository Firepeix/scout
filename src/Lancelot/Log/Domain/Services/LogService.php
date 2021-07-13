<?php


namespace Lancelot\Log\Domain\Services;



use Illuminate\Support\Collection;
use Lancelot\Log\Domain\LogServiceInterface;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;

class LogService implements LogServiceInterface
{
    public function alertShouldBeNecessary(Collection $logs): void
    {
        if ($logs->isNotEmpty()) {
            event(new AlertErrorsOverflowed());
        }
    }
}
