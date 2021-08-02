<?php


namespace Notification\Domain;


use Notification\Domain\ValueObject\TextMessage;

class Message
{
    private ? TextMessage $text = null;
    
    public function __construct(?TextMessage $text)
    {
        $this->text = $text;
    }
    
    public function getContent() : mixed
    {
        return $this->text->value();
    }
}
