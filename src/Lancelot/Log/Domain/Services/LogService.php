<?php

namespace Lancelot\Log\Domain\Services;

use Illuminate\Support\Collection;
use Lancelot\Log\Domain\LogServiceInterface;
use Lancelot\Log\Infrastructure\Events\AlertErrorsOverflowed;
use Lancelot\Log\Infrastructure\Http\NewRelic\Log\PostLogRequest;

class LogService implements LogServiceInterface
{
    public function alertShouldBeNecessary(Collection $logs): void
    {
        if ($logs->isNotEmpty()) {
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
