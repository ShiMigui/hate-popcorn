<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;

class Converter
{
    public static function cast(mixed $value, string $name, Type $type): mixed
    {
        return match ($type) {
            Type::INT    => self::toInt($name, $value),
            Type::FLOAT  => self::toFloat($name, $value),
            Type::BOOL   => self::toBool($name, $value),
            Type::STRING => self::toString($name, $value),
            Type::ARRAY  => self::toArray($name, $value),
            default      => throw new InvalidTypeException('Invalid Type value'),
        };
    }

    private static function toInt(string $name, mixed $value): int
    {
        $result = filter_var($value, FILTER_VALIDATE_INT);

        return (false === $result) ? self::exception($name, 'an integer') : $result;
    }

    private static function toFloat(string $name, mixed $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);

        return (false === $result) ? self::exception($name, 'a decimal') : $result;
    }

    private static function toBool(string $name, mixed $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return (null === $result) ? self::exception($name, 'a boolean') : $result;
    }

    private static function toString(string $name, mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            self::exception($name, 'a string');
        }

        return (string) $value;
    }

    private static function toArray(string $name, mixed $value): array
    {
        if (!is_array($value)) {
            self::exception($name, 'an array');
        }

        return $value;
    }

    private static function exception(string $name, string $expected): never
    {
        throw new InvalidTypeException("Argument '$name' must be $expected");
    }
}
