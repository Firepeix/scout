<?php


namespace Executor\Manager\Infrastructure\Persistence\GoogleSheets;

use Carbon\Carbon;

class ExternalCommandModel
{
    private const NAME_FIELD          = 0;
    private const BODY_FIELD          = 1;
    private const RESPONSE_CODE_FIELD = 2;
    private const RESPONSE_BODY_FIELD = 3;
    private const CREATED_AT_FIELD    = 4;
    
    private string  $id;
    private string  $commandName;
    private ?string $body;
    private ?int    $responseCode;
    private ?string $responseBody;
    private Carbon  $createdAt;
    
    public function __construct(string $id, string $commandName, Carbon $createdAt, string $body = null, int $responseCode = null, string $responseBody = null)
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
        $body      = $attributes[self::BODY_FIELD] === '' ? null : $attributes[self::BODY_FIELD];
        $code      = $attributes[self::RESPONSE_CODE_FIELD] === '' ? null : $attributes[self::RESPONSE_CODE_FIELD];
        $response  = $attributes[self::RESPONSE_BODY_FIELD] === '' ? null : $attributes[self::RESPONSE_BODY_FIELD];
        return new self($id, $attributes[self::NAME_FIELD], $createdAt, $body, $code, $response);
    }
    
    public function toSheetRow(): array
    {
        return [
            self::NAME_FIELD          => $this->commandName,
            self::BODY_FIELD          => $this->body ?? '',
            self::RESPONSE_CODE_FIELD => $this->responseCode ?? '',
            self::RESPONSE_BODY_FIELD => $this->responseBody ?? '',
            self::CREATED_AT_FIELD    => $this->createdAt->toDateTimeString()
        ];
    }
}
