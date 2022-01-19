<?php

namespace Executor\Manager\Domain\ValueObject;

class ResponseCode
{
    private const SUCCESS = 200;
    private const ERROR = 500;
    
    private int $code;
    
    private function __construct(int $code)
    {
        $this->code = $code;
    }
    
    
    public static function success(): self
    {
        return new self(self::SUCCESS);
    }
    
    public static function error(): self
    {
        return new self(self::ERROR);
    }
    
    public function value(): int
    {
        return $this->code;
    }
    
}
