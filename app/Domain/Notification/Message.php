<?php


namespace App\Domain\Notification;


interface Message
{
    public function getContent() : mixed;
}
