<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class InvalidValueException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 422);
    }
}
