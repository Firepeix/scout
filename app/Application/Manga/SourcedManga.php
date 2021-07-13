<?php


namespace App\Application\Manga;


use App\Domain\Manga\SourcedVariation;

class SourcedManga implements SourcedVariation
{
    private int $type;
    private string $externalId;
    private ChapterCheckDecision $decision;
    
    public function init(int $type, string $externalId): void
    {
        $this->type = $type;
        $this->externalId = $externalId;
    }
    
    public function getType(): int
    {
        return $this->type;
    }
    
    public function getDecision(): ? ChapterCheckDecision
    {
        return $this->decision;
    }
    
    public function addDecision(ChapterCheckDecision $decision): void
    {
        $this->decision = $decision;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }
    
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'externalId' => $this->externalId
        ];
    }
}
