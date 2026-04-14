<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;

final class Email extends LimitedString
{
    protected static ?int $max = 320;
    protected static ?int $min = 7;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidInputException('Invalid email format');
        }
        parent::__construct(mb_strtolower($value));
    }
}
