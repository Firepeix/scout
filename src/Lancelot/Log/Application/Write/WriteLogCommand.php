<?php


namespace Lancelot\Log\Application\Write;

use Shared\Domain\Bus\CommandInterface;

class WriteLogCommand implements CommandInterface
{
    private string $message;
    private array $context;
    
    public function __construct(string $message, array $context = [])
    {
        $this->message = $message;
        $this->context = $context;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
    
    public function getContext(): array
    {
        return $this->context;
    }
}
