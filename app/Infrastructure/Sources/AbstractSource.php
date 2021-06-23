<?php


namespace App\Infrastructure\Sources;

use App\Domain\Manga\SourcedVariation;
use App\Domain\Sources\Source;

abstract class AbstractSource implements Source
{
    protected string $template;
    private int $type;
    
    public function __construct(string $template, int $type)
    {
        $this->template = $template;
        $this->type     = $type;
        
    }
    
    public function isSource(SourcedVariation $variation): bool
    {
            return $this->type === $variation->getType();
    }
    
}
