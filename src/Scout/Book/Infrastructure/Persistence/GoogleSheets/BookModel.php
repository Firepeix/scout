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
    
    private int     $id;
    private string  $title;
    private string  $lastReadChapter;
    private string  $externalId;
    private int     $sourceType;
    private ?Carbon $ignoreUntil;
    private ?int    $parentId;
    
    public function __construct(array $attributes)
    {
        $this->id              = $attributes[self::ID_FIELD];
        $this->title           = $attributes[self::TITLE_FIELD];
        $this->lastReadChapter = $attributes[self::CHAPTER_FIELD];
        $this->externalId      = $attributes[self::EXTERNAL_ID_FIELD];
        $this->ignoreUntil     = $attributes[self::IGNORE_UNTIL_FIELD] !== '' ? Carbon::parse($attributes[self::IGNORE_UNTIL_FIELD]) : null;
        $this->sourceType      = $attributes[self::SOURCE_TYPE_FIELD];
        $this->parentId        = $attributes[self::PARENT_ID_FIELD] ?? null;
    }
    
    public static function Create(string $id, string $title, string $lastReadChapter, string $externalId, int $sourceType): self
    {
        $attributes = [
            self::ID_FIELD           => $id,
            self::TITLE_FIELD        => $title,
            self::CHAPTER_FIELD      => $lastReadChapter,
            self::EXTERNAL_ID_FIELD  => $externalId,
            self::SOURCE_TYPE_FIELD  => $sourceType,
            self::IGNORE_UNTIL_FIELD => '',
        ];
        
        return new self($attributes);
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
    
    public function getParentId(): ?int
    {
        return $this->parentId;
    }
    
    public function getIgnoreUntil(): ?Carbon
    {
        return $this->ignoreUntil;
    }
    
    public function setIgnoreUntil(Carbon $ignoreUntil): void
    {
        $this->ignoreUntil = $ignoreUntil;
    }
    
    public function setParentId(string $parentId): void
    {
        $this->parentId = $parentId;
    }
    
    public function toGoogleRow(): array
    {
        return [
            self::ID_FIELD           => $this->id,
            self::TITLE_FIELD        => $this->title,
            self::CHAPTER_FIELD      => $this->lastReadChapter,
            self::EXTERNAL_ID_FIELD  => $this->externalId,
            self::IGNORE_UNTIL_FIELD => $this->ignoreUntil !== null ? $this->ignoreUntil->toDateTimeString() : '',
            self::SOURCE_TYPE_FIELD  => $this->sourceType,
            self::PARENT_ID_FIELD    => $this->parentId !== null ? $this->parentId : '',
        ];
    }
}
