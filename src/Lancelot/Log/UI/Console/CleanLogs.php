<?php

namespace Lancelot\Log\UI\Console;

use Lancelot\Log\Application\Clean\CleanLogsCommand;
use Shared\UI\Console\AbstractCommand;

class CleanLogs extends AbstractCommand
{
    protected $signature = 'log:clean';
    
    public function handle() : void
    {
        $this->dispatcher->dispatchNow(new CleanLogsCommand());
        $this->info('Sucesso: Logs Limpos!');
    }
    
}
