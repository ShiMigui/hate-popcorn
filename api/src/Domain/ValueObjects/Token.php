<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Infrastructure\Utils\TokenGenerator;

class Token extends ValueObject
{
    protected static int $chars = 64; // 64 Hex chars

    public function __construct(string $value)
    {
        if (strlen($value) !== static::$chars) {
            throw new InvalidInputException('Invalid token length');
        }
        parent::__construct($value);
    }

    public static function generate(): static
    {
        return new static(TokenGenerator::generate(static::$chars / 2));
    }
}
