<?php


namespace App\Application\Notification;


use App\Domain\Notification\TextMessage as TextMessageContract;

class TextMessage implements TextMessageContract
{
    private string $content;
    
    public function __construct()
    {
        $this->content = 'Placeholder';
    }
    
    public function init(string $content): TextMessageContract
    {
        $this->content = $content;
        return $this;
    }
    
    public function getContent(): string
    {
        return $this->content;
    }
}
