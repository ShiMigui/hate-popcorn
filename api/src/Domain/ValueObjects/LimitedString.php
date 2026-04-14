<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;

abstract class LimitedString extends ValueObject
{
    protected static ?int $max = null;
    protected static ?int $min = null;
    private int $len;

    public function __construct(string $value)
    {
        $value     = trim($value);
        $this->len = $len = mb_strlen($value);
        $class     = static::className();
        $max       = static::$max;
        $min       = static::$min;

        $hasMax = null !== $max;
        $hasMin = null !== $min;

        if (($hasMax && $len > $max) || ($hasMin && $len < $min)) {
            throw new InvalidInputException("$class length, $len given.");
        }

        parent::__construct($value);
    }

    public function length(): int
    {
        return $this->len;
    }
}
