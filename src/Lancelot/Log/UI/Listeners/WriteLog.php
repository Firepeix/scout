<?php

namespace Lancelot\Log\UI\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Lancelot\Log\Application\Create\CreateLogCommand;
use Lancelot\Log\Infrastructure\Events\NewLogEvent;
use Shared\UI\Listeners\AbstractListener;

class WriteLog extends AbstractListener implements ShouldQueue
{
    public function handle(NewLogEvent $newLogEvent)
    {
        $this->dispatcher->dispatchNow(new CreateLogCommand($newLogEvent->getLog()));
    }
}
