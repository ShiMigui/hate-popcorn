<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Exceptions;

class InfrastructureException extends \RuntimeException
{
    public function __construct(string $message, int $appCode = 0, ?\Throwable $e = null)
    {
        parent::__construct($message, $appCode, $e);
    }
}
