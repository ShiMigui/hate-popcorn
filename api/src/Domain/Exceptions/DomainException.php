<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

abstract class DomainException extends \RuntimeException
{
    public function __construct(string $message, private int $httpCode, int $appCode = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $appCode, $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }
}
