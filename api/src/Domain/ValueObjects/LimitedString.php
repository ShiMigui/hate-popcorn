<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;

abstract class LimitedString extends ValueObject
{
    protected static ?int $max = null;
    protected static ?int $min = null;
    private int $len;

    protected function __construct(string $value)
    {
        $value     = trim($value);
        $this->len = $len = mb_strlen($value);
        $class     = static::className();
        $max       = static::$max;
        $min       = static::$min;

        $hasMax = null !== $max;
        $hasMin = null !== $min;

        if (($hasMax && $len > $max) || ($hasMin && $len < $min)) {
            $range = match (true) {
                $hasMin && $hasMax => "$min-$max",
                $hasMin            => ">= $min",
                $hasMax            => "<= $max",
            };
            throw new InvalidInputException("$class length must be $range characters, $len given.");
        }

        parent::__construct($value);
    }

    public function length(): int
    {
        return $this->len;
    }
}
