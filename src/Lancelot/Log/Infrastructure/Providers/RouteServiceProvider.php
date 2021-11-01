<?php

namespace Lancelot\Log\Infrastructure\Providers;

use Lancelot\Log\UI\Api\CleanLogs;
use Shared\Infrastructure\Providers\RouteServiceProvider as BaseRouteService;

class RouteServiceProvider extends BaseRouteService
{
    protected array $actions = [
        CleanLogs::class
    ];
}
