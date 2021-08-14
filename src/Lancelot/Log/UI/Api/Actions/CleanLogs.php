<?php

namespace Lancelot\Log\UI\Api\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Lancelot\Log\Application\Clean\CleanLogsCommand;

class CleanLogs extends Controller
{
    public function __invoke(): JsonResponse
    {
        sleep(5);
        $this->dispatchSync(new CleanLogsCommand());
        return new JsonResponse(['success' => true], 200);
    }
}
