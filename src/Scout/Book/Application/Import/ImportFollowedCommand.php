<?php


namespace Scout\Book\Application\Import;
use Scout\Book\Domain\ValueObject\SourceType;
use Shared\Domain\Bus\CommandInterface;

class ImportFollowedCommand implements CommandInterface
{
    private SourceType $sourceType;
    
    public function __construct(int $sourceType)
    {
        $this->sourceType = new SourceType($sourceType);
    }
    
    public function getSourceType(): SourceType
    {
        return $this->sourceType;
    }
}
