<?php

namespace Scout\Book\UI\Console;

use Scout\Book\Application\Check\CheckChaptersCommand as BusCheckChaptersCommand;
use Shared\UI\Console\AbstractCommand;

class CheckChaptersCommand extends AbstractCommand
{
    protected $signature = 'manga:check-chapters {id?} {name?} {--batch=0} {--batch-size=10} {--async}';
    
    public function handle(): void
    {
        $args = [
            $this->argument('id'),
            $this->argument('name'),
            $this->option('batch'),
            $this->option('batch-size'),
            $this->option('async')
        ];
        
        $command = new BusCheckChaptersCommand(...$args);
        
        $command->setOnDone(function (? string $newChapter, string $name) {
            if ($newChapter !== null) {
                $this->line("O manga <fg=cyan>$name</> tem o novo capitulo: <fg=green>$newChapter</>");
            }
        });
        
        $this->dispatcher->dispatchNow($command);
        $this->info('Sucesso: Capítulos Checados!');
    }
    
}
