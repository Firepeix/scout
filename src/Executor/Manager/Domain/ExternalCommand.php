<?php

namespace Executor\Manager\Domain;

use Carbon\Carbon;
use Executor\Manager\Domain\ValueObject\Body;
use Executor\Manager\Domain\ValueObject\CommandName;
use Executor\Manager\Domain\ValueObject\ResponseCode;
use Shared\Domain\Util\Option\None;
use Shared\Domain\Util\Option\Option;
use Shared\Domain\Util\Option\Some;
use Shared\Domain\ValueObject\Id;

class ExternalCommand
{
    private Id  $id;
    private CommandName  $commandName;
    private Body $body;
    
    /**
     * @var Option<Body>
     */
    private Option    $responseCode;
    
    /**
     * @var Option<Body>
     */
    private Option $responseBody;
    private Carbon  $createdAt;
    
    public function __construct(Id $id, CommandName $commandName, Body $body, Carbon $createdAt)
    {
        $this->id           = $id;
        $this->commandName  = $commandName;
        $this->body         = $body;
        $this->responseCode = new None();
        $this->responseBody = new None();
        $this->createdAt    = $createdAt;
    }
    
    public function getId(): Id
    {
        return $this->id;
    }
    
    /**
     * @return Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }
    
    /**
     * @return Option<ResponseCode>
     */
    public function getResponseCode(): Option
    {
        return $this->responseCode;
    }
    
    /**
     * @return Option<Body>
     */
    public function getResponseBody(): Option
    {
        return $this->responseBody;
    }
    
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
    
    public function complete(ResponseCode $code, Body $responseBody): void
    {
        $this->responseCode = new Some($code);
        $this->responseBody = new Some($responseBody);
    }
    
    public function hasNotBeenCompleted(): bool
    {
        return $this->responseCode->isNone();
    }
    
    public function getName(): CommandName
    {
        return $this->commandName;
    }
    
    public function getArgs() : array
    {
        return $this->body->array();
    }
    
}
