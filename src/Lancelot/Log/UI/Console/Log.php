<?php

namespace Lancelot\Log\UI\Console;

use Lancelot\Log\Application\Write\WriteLogCommand;
use Shared\UI\Console\AbstractCommand;

class Log extends AbstractCommand
{
    protected $signature = 'log';
    
    public function handle() : void
    {
        $this->dispatcher->dispatchNow(new WriteLogCommand('Teste', ['success' => true]));
        $this->info('Sucesso: Log escrito!');
    }
    
}
