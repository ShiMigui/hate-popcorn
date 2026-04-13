<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

abstract class AppException extends \RuntimeException
{
    public function __construct(string $message, private int $httpCode = 500, ?\Throwable $error = null)
    {
        parent::__construct($message, previous: $error);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
