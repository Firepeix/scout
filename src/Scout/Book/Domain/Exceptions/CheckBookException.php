<?php

namespace Scout\Book\Domain\Exceptions;

use Exception;
use Scout\Book\Domain\Book;
use Shared\Domain\Exceptions\AbstractException;

class CheckBookException extends AbstractException
{
    public function __construct(Book $book, Exception $exception)
    {
        parent::__construct(['book' => $book->toArray()], 'Erro ao verificar um livro', $exception->code, $exception);
    }
}
