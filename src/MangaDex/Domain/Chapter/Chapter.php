<?php


namespace MangaDex\Domain\Chapter;


class Chapter
{
    public const TYPE = 'chapter';
    
    private string $number;
    
    public function __construct(array $content)
    {
        $this->number = $content['data']['attributes']['chapter'];
    }
    
    public function getNumber() : string
    {
        return $this->number;
    }
}
