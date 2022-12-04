<?php

namespace Lancelot\Log\UI\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Shared\Infrastructure\Http\Response\SuccessResponse;
use Shared\Infrastructure\Http\Route;

#[Route(url: '/logs', method: 'DELETE')]
class CleanLogs extends Controller
{
    public function __invoke(): JsonResponse
    {
        $this->dispatchSync(new CleanLogsCommand());
        return new SuccessResponse("Logs deletados com sucesso");
    }
}
