<?php

namespace Executor\Manager\Domain\ValueObject;

class ResponseCode
{
    private const BLANK = 0;
    private const EXECUTING = 100;
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
    
    public static function executing(): self
    {
        return new self(self::EXECUTING);
    }
    
    public static function define(int $code) : self
    {
        return new self($code);
    }
    
    public static function blank(): self
    {
        return new self(self::BLANK);
    }
    
    public function value(): int
    {
        return $this->code;
    }
    
    public function isLocked(): bool
    {
        return $this->code === self::EXECUTING;
    }
    
    public function isFinal(): bool
    {
        return $this->code !== self::EXECUTING && $this->code !== self::BLANK;
    }
    
}
