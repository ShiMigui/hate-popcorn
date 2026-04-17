<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

abstract class DomainException extends \RuntimeException
{
    public const int HTTP_CODE = 400;
}
