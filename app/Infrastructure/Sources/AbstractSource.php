<?php


namespace App\Infrastructure\Sources;

use App\Domain\Sources\Source;

abstract class AbstractSource implements Source
{
    protected string $template;
    private int      $type;
    private string   $name;
    
    public function __construct(string $template, int $type, string $name)
    {
        $this->template = $template;
        $this->type     = $type;
        $this->name     = $name;
    }
    
    public function toArray(): array
    {
        return [
            'template' => $this->template,
            'type'     => $this->type,
            'name'     => $this->name,
        ];
    }
}
