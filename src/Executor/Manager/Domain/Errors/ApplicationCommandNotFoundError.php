<?php

namespace Executor\Manager\Domain\Errors;

use Exception;
use JetBrains\PhpStorm\Pure;

class ApplicationCommandNotFoundError extends Exception
{
    const CODE = 1;
    #[Pure]
    public function __construct(string $name)
    {
        parent::__construct("Não foi possível encontrar o comando: $name", self::CODE);
    }
}
