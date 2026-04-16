<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Exceptions;

final class DatabaseException extends InfrastructureException
{
    public function __construct(\Throwable $e, int $appCode = 1000, string $message = 'Database Exception')
    {
        parent::__construct($message, $appCode, $e);
    }
}
