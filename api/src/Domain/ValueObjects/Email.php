<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidValueException;

final class Email extends Varchar
{
    public function __construct(string $value)
    {
        $value = trim($value);
        parent::__construct($value, 320, 7, 'Email');

        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidValueException("Invalid email format: '$value'");
        }
    }
}
