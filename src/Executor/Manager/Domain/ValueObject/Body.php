<?php

namespace Executor\Manager\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;

class Body
{
    private string $rawBody;
    
    public function __construct(string $rawBody)
    {
        $this->rawBody = $rawBody;
    }
    
    #[Pure]
    public static function empty(): self
    {
        return new self('');
    }
    
    public static function error(string $error = 'ERROR'): self
    {
        return new self(json_encode(['error' => $error]));
    }
    
    public static function success(array $data = []): self
    {
        return new self(json_encode(['success' => true, ...$data]));
    }
    
    public function array(): array
    {
        return json_decode($this->rawBody, true);
    }
    
    public function string(): string
    {
        return $this->rawBody;
    }
}
