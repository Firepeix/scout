<?php

namespace Scout\Book\Application\Read;

use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class ReadBookCommandHandler implements CommandHandlerInterface
{
    private BookServiceInterface $service;
    private BookRepositoryInterface $repository;
    
    public function __construct(BookServiceInterface $service, BookRepositoryInterface $repository)
    {
        $this->service    = $service;
        $this->repository = $repository;
    }
    
    /**
     * @param ReadBookCommand $command
     */
    public function handle(CommandInterface $command): ? CommandResponseInterface
    {
        $book = $this->repository->find($command->getId());
        $readUpto = $command->getReadUpto() ?? $book->getLastChapterRead()->read();
        $this->service->read($book, $readUpto);
        $this->repository->updateBook($book);
        return null;
    }
}
