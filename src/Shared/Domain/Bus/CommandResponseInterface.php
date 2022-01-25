<?php


namespace Shared\Domain\Bus;


interface CommandResponseInterface
{
    public function getData(): array;

}
