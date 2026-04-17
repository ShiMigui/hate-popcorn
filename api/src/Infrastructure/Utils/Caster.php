<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;

enum Caster
{
    case INT;
    case STRING;
    case BOOL;
    case FLOAT;
    case ARRAY;

    public function cast(string $name, mixed $value): mixed
    {
        return match ($this) {
            self::INT    => $this->toInt($name, $value),
            self::FLOAT  => $this->toFloat($name, $value),
            self::BOOL   => $this->toBool($name, $value),
            self::STRING => $this->toString($name, $value),
            self::ARRAY  => $this->toArray($name, $value),
        };
    }

    private function toInt(string $name, mixed $value): int
    {
        $result = filter_var($value, FILTER_VALIDATE_INT);

        return (false === $result) ? $this->exception($name, 'an integer') : $result;
    }

    private function toFloat(string $name, mixed $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);

        return (false === $result) ? $this->exception($name, 'a decimal') : $result;
    }

    private function toBool(string $name, mixed $value): bool
    {
        $result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return (null === $result) ? $this->exception($name, 'a boolean') : $result;
    }

    private function toString(string $name, mixed $value): string
    {
        if (is_array($value) || is_object($value)) {
            $this->exception($name, 'a string');
        }

        return (string) $value;
    }

    private function toArray(string $name, mixed $value): array
    {
        if (!is_array($value)) {
            $this->exception($name, 'an array');
        }

        return $value;
    }

    private function exception(string $name, string $expected): never
    {
        throw new InvalidTypeException("Argument '$name' must be $expected");
    }
}
