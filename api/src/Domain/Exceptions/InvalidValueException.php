<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class InvalidValueException extends DomainException
{
    public const int HTTP_CODE = 422;
}
