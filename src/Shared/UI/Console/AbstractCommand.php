<?php


namespace Shared\UI\Console;

use Illuminate\Bus\Dispatcher;
use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    protected Dispatcher $dispatcher;
    
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
    }
}
