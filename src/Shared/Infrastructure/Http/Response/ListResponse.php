<?php

namespace Shared\Infrastructure\Http\Response;

use Illuminate\Support\Collection;

/**
 * @phpstan-template T
 */
final class ListResponse extends DataResponse
{
    /**
     * @var T
     */
    private Collection $items;
    
    public function __construct(Collection $items)
    {
        $this->items = $items;
        parent::__construct($this->items, ["count" => $items->count()]);
    }
}
