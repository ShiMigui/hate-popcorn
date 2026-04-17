<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;

class Assert
{
    /**
     * @template T
     *
     * @param T|null $value
     *
     * @return T
     *
     * @throws InvalidTypeException
     */
    public static function notNull(mixed $value, string $field = 'Value'): mixed
    {
        return $value ?? throw new InvalidTypeException("$field cannot be null");
    }

    public static function keyNotNull(array $arr, string $key, ?string $field = null): mixed
    {
        return $arr[$key]
          ?? throw new InvalidTypeException(sprintf('Field "%s" cannot be null', $field ?? $key));
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
