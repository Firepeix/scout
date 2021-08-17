<?php


namespace Shared\UI\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;

abstract class AbstractCommand extends Command
{
    protected Dispatcher $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
    }
}
