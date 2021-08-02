<?php


namespace Lancelot\Pulse\Domain\Services;


use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Collection;
use Lancelot\Pulse\Domain\Pulse;
use Notification\Application\Dispatch\DispatchNotificationCommand;

class PulseService implements PulseServiceInterface
{
    private Dispatcher $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    
    public function fire(Collection $pulses): void
    {
        $pulses->each(function (Pulse $pulse) {
            if ($pulse->shouldFire()) {
                $alert = "Alerta: {$pulse->getName()} na sua aplicação: <b>". env('APP_NAME') . '</b>';
                $this->dispatcher->dispatch(new DispatchNotificationCommand($alert));
            }
        });
    }
}
