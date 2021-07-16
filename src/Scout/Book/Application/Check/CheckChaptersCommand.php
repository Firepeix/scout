<?php


namespace Scout\Book\Application\Check;
use Closure;
use Scout\Book\Domain\ValueObject\Id;
use Scout\Book\Domain\ValueObject\Title;
use Shared\Domain\Bus\CommandInterface;

class CheckChaptersCommand implements CommandInterface
{
    private ? Id $id;
    private ? Title $title;
    private int $batch;
    private int $batchSize;
    private bool $executeAsync;
    private Closure $onDone;
    
    public function __construct(?Id $id, ?Title $title, int $batch, int $batchSize, bool $executeAsync)
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->batch        = $batch;
        $this->batchSize    = $batchSize;
        $this->executeAsync = $executeAsync;
    }
    
    public function getId(): ?Id
    {
        return $this->id;
    }
    
    public function getTitle(): ?Title
    {
        return $this->title;
    }
    
    public function getBatchNumber(): int
    {
        return $this->batch;
    }
    
    public function getBatchSize(): int
    {
        return $this->batchSize;
    }
    
    public function shouldExecuteAsync(): bool
    {
        return $this->executeAsync;
    }
    
    public function getOnDone(): Closure
    {
        return $this->onDone;
    }

    public function setOnDone(Closure $closure) : void
    {
        $this->onDone = $closure;
    }
}
