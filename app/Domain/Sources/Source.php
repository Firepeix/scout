<?php


namespace App\Domain\Sources;

interface Source
{
    public function toArray() : array;
}
