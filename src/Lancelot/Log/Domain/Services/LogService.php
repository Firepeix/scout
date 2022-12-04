<?php

namespace Lancelot\Log\Domain\Services;

use Illuminate\Support\Collection;
use Lancelot\Log\Domain\LogServiceInterface;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;
use Lancelot\Log\Infrastructure\Http\NewRelic\Log\PostLogRequest;

class LogService implements LogServiceInterface
{
    private const MINIMUM_LOG_AMOUNT = 20;
    
    public function alertShouldBeNecessary(Collection $logs): void
    {
        if ($logs->count() >= self::MINIMUM_LOG_AMOUNT) {
            event(new AlertErrorsOverflowed());
        }
    }
    
    public function sendToNewRelic(array $log): void
    {
        $request = new PostLogRequest($log);
        $request->execute();
    }
    
    public function format(array $log): array
    {
        $log['hostname'] = config('app.url');
        $log['service'] = config('app.name');
        unset($log['type']);
        
        return $log;
    }
    
    
}
