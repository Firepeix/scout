<?php


namespace Scout\Book\Application\Check;


use Illuminate\Support\Collection;
use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class CheckChaptersCommandHandler implements CommandHandlerInterface
{
    private BookServiceInterface $service;
    private BookRepositoryInterface $repository;
    
    public function __construct(BookServiceInterface $service, BookRepositoryInterface $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }
    
    public function handle(CheckChaptersCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $books = $this->repository->getMainBooks($command->getId(), $command->getTitle());
        $books = $books->chunk($command->getBatchSize())[$command->getBatchNumber()] ?? new Collection();
        if ($command->shouldExecuteAsync()) {
            $this->service->checkBooksAsync($books);
            return null;
        }
        $this->service->checkBooksSync($books, $command->getOnDone());
        return null;
    }
}
