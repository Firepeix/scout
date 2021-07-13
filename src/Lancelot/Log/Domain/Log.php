<?php


namespace Lancelot\Log\Domain;


use Lancelot\Log\Domain\ValueObject\Id;

class Log implements LogInterface
{
    public const ERROR = 'ERROR';
    
    private Id $id;
    
    public function __construct(Id $id)
    {
        $this->id = $id;
    }
}
