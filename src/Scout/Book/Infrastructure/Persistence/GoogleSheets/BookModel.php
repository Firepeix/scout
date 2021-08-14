<?php


namespace Scout\Book\Infrastructure\Persistence\GoogleSheets;


use Carbon\Carbon;

class BookModel
{
    private const ID_FIELD           = 0;
    private const TITLE_FIELD        = 1;
    private const CHAPTER_FIELD      = 2;
    private const EXTERNAL_ID_FIELD  = 3;
    private const IGNORE_UNTIL_FIELD = 4;
    private const SOURCE_TYPE_FIELD  = 5;
    private const PARENT_ID_FIELD    = 6;
    
    private int    $position;
    private int     $id;
    private string  $title;
    private string  $lastReadChapter;
    private string  $externalId;
    private ?Carbon $ignoreUntil;
    private int     $sourceType;
    private ?int    $parentId;
    
    public function __construct(int $position, array $attributes)
    {
        $this->id              = $attributes[self::ID_FIELD];
        $this->title           = $attributes[self::TITLE_FIELD];
        $this->lastReadChapter = $attributes[self::CHAPTER_FIELD];
        $this->externalId      = $attributes[self::EXTERNAL_ID_FIELD];
        $this->ignoreUntil     = $attributes[self::IGNORE_UNTIL_FIELD] !== '' ? Carbon::parse($attributes[self::IGNORE_UNTIL_FIELD]) : null;
        $this->sourceType      = $attributes[self::SOURCE_TYPE_FIELD];
        $this->parentId        = $attributes[self::PARENT_ID_FIELD] ?? null;
        $this->position = $position;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getLastReadChapter(): string
    {
        return $this->lastReadChapter;
    }
    
    public function getExternalId(): string
    {
        return $this->externalId;
    }
    
    public function getSourceType(): int
    {
        return $this->sourceType;
    }
    
    public function getPosition(): int
    {
        return $this->position;
    }
    
    public function getParentId(): ?int
    {
        return $this->parentId;
    }
    
    public function getIgnoreUntil(): ? Carbon
    {
        return $this->ignoreUntil;
    }
    
    
}
