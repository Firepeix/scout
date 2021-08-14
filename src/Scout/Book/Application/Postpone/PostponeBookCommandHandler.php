<?php

namespace Scout\Book\Application\Postpone;

use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class PostponeBookCommandHandler implements CommandHandlerInterface
{
    private BookServiceInterface $service;
    private BookRepositoryInterface $repository;
    
    public function __construct(BookServiceInterface $service, BookRepositoryInterface $repository)
    {
        $this->service    = $service;
        $this->repository = $repository;
    }
    
    /**
     * @param PostponeBookCommand $command
     */
    public function handle(CommandInterface $command): ? CommandResponseInterface
    {
        $book = $this->repository->find($command->getId());
        dd(213);
        $this->service->postponeBook($book, $command->until());
        return null;
    }
}
