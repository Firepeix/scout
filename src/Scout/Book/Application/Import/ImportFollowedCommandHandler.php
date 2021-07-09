<?php


namespace Scout\Book\Application\Import;


use Scout\Book\Domain\BookRepositoryInterface;
use Scout\Book\Domain\BookServiceInterface;
use Scout\Source\Domain\SourceRepository;
use Shared\Domain\Bus\CommandHandlerInterface;
use Shared\Domain\Bus\CommandInterface;
use Shared\Domain\Bus\CommandResponseInterface;

class ImportFollowedCommandHandler implements CommandHandlerInterface
{
    private SourceRepository $sourceRepository;
    private BookServiceInterface $bookService;
    private BookRepositoryInterface $repository;
    
    public function __construct(SourceRepository $sourceRepository, BookServiceInterface $bookService, BookRepositoryInterface $repository)
    {
        $this->sourceRepository = $sourceRepository;
        $this->bookService = $bookService;
        $this->repository = $repository;
    }
    
    public function handle(ImportFollowedCommand|CommandInterface $command): ? CommandResponseInterface
    {
        $source        = $this->sourceRepository->findSourceByType($command->getSourceType());
        $books = $this->bookService->getFollowedBooks($source);
        $this->repository->insert($books);
        
        return null;
    }
}
