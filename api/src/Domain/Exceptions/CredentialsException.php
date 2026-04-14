<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class CredentialsException extends AppException
{
    public function __construct(string $message = 'Invalid credentials')
    {
        parent::__construct($message, 400);
    }
}
