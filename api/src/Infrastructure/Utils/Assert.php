<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;

class Assert
{
    /**
     * Throws exception if value is null.
     *
     * @template T
     *
     * @param T $value
     *
     * @return T Returns value if not null
     *
     * @throws InvalidTypeException
     */
    public static function notNull(mixed $value, string $field = 'Value'): mixed
    {
        return $value ?? throw new InvalidTypeException("$field cannot be null");
    }

    /**
     * Throws exception if value is NOT null.
     *
     * @throws InvalidTypeException
     */
    public static function null(mixed $value, string $field): void
    {
        if (null !== $value) {
            throw new InvalidTypeException(sprintf('%s should be null', $field));
        }
    }
}
