<?php

namespace Lancelot\Log\UI\Api\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Lancelot\Log\Application\Clean\CleanLogsCommand;

class CleanLogs extends Controller
{
    public function __invoke(): JsonResponse
    {
        $this->dispatchSync(new CleanLogsCommand());
        return new JsonResponse(['success' => true], 200);
    }
}
