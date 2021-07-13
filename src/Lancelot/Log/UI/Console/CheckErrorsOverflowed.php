<?php

namespace Lancelot\Log\UI\Console;

use Lancelot\Log\Application\CheckErrors\CheckErrorsAlert;
use Shared\UI\Console\AbstractCommand;

class CheckErrorsOverflowed extends AbstractCommand
{
    protected $signature = 'log:check-error-overflow';
    
    public function handle() : void
    {
        $this->dispatcher->dispatchNow(new CheckErrorsAlert());
        $this->info('Sucesso: Alerta Enviado!');
    }
    
}
