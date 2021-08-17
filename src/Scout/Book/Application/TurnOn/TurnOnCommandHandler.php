<?php

namespace Scout\Book\Application\TurnOn;

use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class TurnOnCommandHandler implements CommandHandlerInterface
{
    private BookServiceInterface $service;
    private BookRepositoryInterface $repository;
    
    public function __construct(BookServiceInterface $service, BookRepositoryInterface $repository)
    {
        $this->service    = $service;
        $this->repository = $repository;
    }
    
    /**
     * @param TurnOnBookCommand $command
     */
    public function handle(CommandInterface $command): ? CommandResponseInterface
    {
        $book = $this->repository->find($command->getId());
        $this->service->turnOn($book);
        $this->repository->updateBook($book);
        return null;
    }
}
