<?php

namespace Lancelot\Log\Infrastructure\Http\NewRelic\Log;

class PostLogResponse
{
    private string $requestId;
    
    public function __construct(array $content)
    {
        $this->requestId = $content['requestId'];
    }
    
    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
