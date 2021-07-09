<?php

namespace Scout\Book\UI\Console;

use Scout\Book\Application\Import\ImportFollowedCommand;
use Shared\UI\Console\AbstractCommand;

class ImportFollowedBooksCommand extends AbstractCommand
{
    protected $signature = 'book:import-followed {sourceType}';
    
    public function handle() : void
    {
        $this->dispatcher->dispatchNow(new ImportFollowedCommand($this->argument('sourceType')));
        $this->info('Sucesso: Livros Importados!');
    }
    
}
