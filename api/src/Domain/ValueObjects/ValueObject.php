<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

abstract class ValueObject
{
    protected function __construct(private mixed $value)
    {
    }

    final public function get(): mixed
    {
        return $this->value;
    }

    final public static function className(): string
    {
        return basename(str_replace('\\', '/', static::class));
    }

    public static function from(mixed $value): static
    {
        return new static($value);
    }
}
