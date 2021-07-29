<?php


namespace Lancelot\Pulse\UI\Console;

use Lancelot\Pulse\Application\Fire\FirePulsesCommand;
use Shared\UI\Console\AbstractCommand;

class FirePulses extends AbstractCommand
{
    protected $signature = 'pulse:fire';
    
    public function handle() : void
    {
        $this->dispatcher->dispatch(new FirePulsesCommand());
        $this->info('Sucesso: Pulsos Disparados!');
    }
}
