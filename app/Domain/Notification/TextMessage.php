<?php


namespace App\Domain\Notification;


interface TextMessage extends Message
{
    public function init(string $content) : self;
    
    public function getContent(): string;
}
