<?php

namespace Lancelot\Log\Infrastructure\Http\NewRelic\Log;

use Carbon\Carbon;
use Lancelot\Log\Infrastructure\Http\NewRelic\NewRelicRequest;

class PostLogRequest extends NewRelicRequest
{
    private const URI = 'log/v1';
    private const METHOD = 'POST';
    
    private array $log;
    
    public function __construct(array $log)
    {
        parent::__construct(self::METHOD, self::URI);
        $this->log = $log;
        $this->prepare();
    }
    
    private function prepare(): void
    {
        $this->log['timestamp'] = Carbon::parse($this->log['@timestamp'])->getTimestamp();
    }
    
    protected function getBody(): array
    {
        return $this->log;
    }
    
    protected function createResponse(array $content): PostLogResponse
    {
        return new PostLogResponse($content);
    }
    
    public function execute(): PostLogResponse
    {
        return parent::execute();
    }
}
