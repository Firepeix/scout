<?php

namespace Executor\Manager\Domain;

use Carbon\Carbon;
use Executor\Manager\Domain\ValueObject\ResponseBody;
use Executor\Manager\Domain\ValueObject\ResponseCode;
use Shared\Domain\ValueObject\Id;
use Shared\Domain\ValueObject\StringValueObject;

class ExternalCommand
{
    private Id  $id;
    private StringValueObject  $commandName;
    private ResponseBody $body;
    private ResponseCode    $responseCode;
    private ?string $responseBody;
    private Carbon  $createdAt;
}
