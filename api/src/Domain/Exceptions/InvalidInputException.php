<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class InvalidInputException extends AppException
{
    public function __construct(string $input)
    {
        parent::__construct("Invalid input: $input", 400);
    }
}
