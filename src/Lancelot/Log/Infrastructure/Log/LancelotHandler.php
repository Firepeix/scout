<?php


namespace Lancelot\Log\Infrastructure\Log;


use Exception;
use Monolog\Handler\AbstractProcessingHandler;

class LancelotHandler extends AbstractProcessingHandler
{
    private string $event;
    
    public function __construct(string $event)
    {
        parent::__construct();
        $this->event = $event;
    }
    
    protected function write(array $record): void
    {
        try {
            $log = json_decode($record['formatted'], true);
            event(new $this->event($log));
        } catch (Exception $exception) {
            dd($exception);
        }
    }
}
