<?php


namespace Executor\Manager\Infrastructure\Persistence\GoogleSheets;

use Carbon\Carbon;
use Shared\Domain\Util\Option\None;
use Shared\Domain\Util\Option\Option;
use Shared\Domain\Util\Option\Some;

class ExternalCommandModel
{
    private const NAME_FIELD          = 0;
    private const BODY_FIELD          = 1;
    private const RESPONSE_CODE_FIELD = 2;
    private const RESPONSE_BODY_FIELD = 3;
    private const CREATED_AT_FIELD    = 4;
    
    private string  $id;
    private string  $commandName;
    private string $body;
    /**
     * @var Option<int>
     */
    private Option    $responseCode;
    /**
     * @var Option<string>
     */
    private Option $responseBody;
    private Carbon  $createdAt;
    
    /**
     * @param string $id
     * @param string $commandName
     * @param Carbon $createdAt
     * @param string $body
     * @param Option<int> $responseCode
     * @param Option<string> $responseBody
     */
    public function __construct(string $id, string $commandName, Carbon $createdAt, string $body, Option $responseCode, Option $responseBody)
    {
        $this->id           = $id;
        $this->commandName  = $commandName;
        $this->body         = $body;
        $this->responseCode = $responseCode;
        $this->responseBody = $responseBody;
        $this->createdAt    = $createdAt;
    }
    
    public static function Create($id, array $attributes)
    {
        $createdAt = Carbon::parse($attributes[self::CREATED_AT_FIELD]);
        $body      = $attributes[self::BODY_FIELD];
        $code      = $attributes[self::RESPONSE_CODE_FIELD] === '' ? new None() : new Some($attributes[self::RESPONSE_CODE_FIELD]);
        $response  = $attributes[self::RESPONSE_BODY_FIELD] === '' ? new None() : new Some($attributes[self::RESPONSE_BODY_FIELD]);
        return new self($id, $attributes[self::NAME_FIELD], $createdAt, $body, $code, $response);
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getCommandName(): string
    {
        return $this->commandName;
    }
    
    public function getBody(): string
    {
        return $this->body;
    }
    
    /**
     * @return Option<string>
     */
    public function getResponseCode(): Option
    {
        return $this->responseCode;
    }
    
    /**
     * @return Option<string>
     */
    public function getResponseBody(): Option
    {
        return $this->responseBody;
    }
    
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
    
    public function hasCompleted(): bool
    {
        return $this->responseCode->isSome();
    }
    
    
    public function toSheetRow(): array
    {
        return [
            self::NAME_FIELD          => $this->commandName,
            self::BODY_FIELD          => $this->body,
            self::RESPONSE_CODE_FIELD => $this->responseCode->unwrapOr(''),
            self::RESPONSE_BODY_FIELD => $this->responseBody->unwrapOr(''),
            self::CREATED_AT_FIELD    => $this->createdAt->toDateTimeString()
        ];
    }
    
    public static function emptySheetRow(): array
    {
        return [
            self::NAME_FIELD          => '',
            self::BODY_FIELD          => '',
            self::RESPONSE_CODE_FIELD => '',
            self::RESPONSE_BODY_FIELD => '',
            self::CREATED_AT_FIELD    => ''
        ];
    }
}
