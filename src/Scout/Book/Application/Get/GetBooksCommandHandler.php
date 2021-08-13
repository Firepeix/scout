<?php

namespace Scout\Book\Application\Get;

use Scout\Book\Domain\BookRepositoryInterface;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class GetBooksCommandHandler implements CommandHandlerInterface
{
    private BookRepositoryInterface $repository;
    
    public function __construct(BookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @param GetBooksCommand $command
     */
    public function handle(CommandInterface $command): ? CommandResponseInterface
    {
        $books = $this->repository->getMainBooks($command->getId(), $command->getTitle(), !$command->includeIgnored());
        return new GetBooksCommandResponse($books);
    }
}
