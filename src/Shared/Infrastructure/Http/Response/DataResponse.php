<?php

namespace Shared\Infrastructure\Http\Response;

use Illuminate\Http\JsonResponse;

/**
 * @phpstan-template T
 */
class DataResponse extends JsonResponse
{
    /**
     * @phpstan-var T
     */
    private mixed $item;
    
    public function __construct(mixed $item, array $metadata = [])
    {
        $this->item = $item;
        $body = ["data" => $this->item];
        if (!empty($metadata)) {
            $body = array_merge($body, compact("metadata"));
        }
        parent::__construct($body);
    }
}
