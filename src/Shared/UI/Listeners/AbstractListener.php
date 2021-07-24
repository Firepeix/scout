<?php


namespace Shared\UI\Listeners;

use Illuminate\Bus\Dispatcher;

abstract class AbstractListener
{
    protected Dispatcher $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
