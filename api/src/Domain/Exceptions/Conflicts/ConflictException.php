<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions\Conflicts;

class ConflictException extends \Hatepopcorn\Domain\Exceptions\DomainException
{
    public const int HTTP_CODE = 409;
}
