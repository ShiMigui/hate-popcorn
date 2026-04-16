<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class InvalidTypeException extends DomainException
{
    public function __construct(string $message, int $httpCode = 400, int $appCode = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $httpCode, $appCode, $previous);
    }
}
