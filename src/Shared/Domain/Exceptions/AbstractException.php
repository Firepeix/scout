<?php

namespace Shared\Domain\Exceptions;

use Exception;
use Throwable;

abstract class AbstractException extends Exception
{
    private array $context;
    
    public function __construct(array $context, string $message, int $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }
    
    public function context() : array
    {
        return $this->context;
    }
}
