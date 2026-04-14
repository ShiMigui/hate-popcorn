<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;

abstract class Id extends ValueObject
{
    public function __construct(int $value)
    {
        $class = static::className();

        if ($value <= 0) {
            throw new InvalidInputException("$class must be a positive integer, given $value");
        }

        parent::__construct($value);
    }
}
