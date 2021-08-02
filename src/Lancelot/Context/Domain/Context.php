<?php


namespace Lancelot\Context\Domain;


use Lancelot\Context\Domain\ValueObject\Database;
use Lancelot\Context\Domain\ValueObject\Tables;

class Context
{
    private Database $database;
    private Tables $tables;
    
    public function __construct(Database $database, Tables $tables)
    {
        $this->database = $database;
        $this->tables   = $tables;
    }
    
    public function getDatabase() : Database
    {
        return $this->database;
    }
    
    public function getTables(): Tables
    {
        return $this->tables;
    }
}
