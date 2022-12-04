<?php

namespace Shared\Infrastructure\Http\Response;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{
    public function __construct(string $message)
    {
        parent::__construct(compact("message"));
    }
}
