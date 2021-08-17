<?php


namespace Lancelot\Log\UI\Api\Routes;

use Lancelot\Log\UI\Api\Actions\CleanLogs;
use Shared\UI\App\AbstractRoute;

class LogRoutes extends AbstractRoute
{
    protected function routes()
    {
        $this->router->group(['prefix' => '/'], function () {
            $this->router->delete('/logs', CleanLogs::class);
        });
    }
    
}
