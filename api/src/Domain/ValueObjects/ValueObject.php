<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

abstract class ValueObject
{
    protected static ?string $name;

    public function __construct(public readonly mixed $value)
    {
    }

    final public static function from(mixed $value): static
    {
        return new static($value);
    }

    public function equals(ValueObject $other): bool
    {
        return $other->value === $this->value;
    }

    final protected static function name(): string
    {
        return static::$name ??= self::formatName(static::class);
    }

    private static function formatName(string $class): string
    {
        $short = substr(strrchr($class, '\\'), 1); // Hatepopcorn\Domain\ValueObjects => ValueObject

        return preg_replace('/(?<!^)[A-Z]/', ' $0', $short); // ValueObject => Value Object
    }
}
