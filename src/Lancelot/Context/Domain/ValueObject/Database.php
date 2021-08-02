<?php

namespace Lancelot\Context\Domain\ValueObject;

use Lancelot\Context\Domain\ValueObject\Database\Engine;

class Database
{
    private array $connection;
    private Engine $engine;
    
    public function __construct(string $connection, Engine $engine)
    {
        $this->connection = json_decode($connection, true);
        $this->engine     = $engine;
    }
    
    public function getEngineName() : string
    {
        return $this->engine->value();
    }
    
    public function getConnection() : string
    {
        return $this->connection['host'] ?? '';
    }
}
