<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class EnvException extends AppException
{
    public function __construct(string $envName)
    {
        parent::__construct("Env not found: '$envName'", 500);
    }
}
