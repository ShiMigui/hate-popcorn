<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

enum InputType
{
    case INT;
    case STRING;
    case BOOL;

    public function cast(string $name, mixed $value): mixed
    {
        return match ($this) {
            self::BOOL   => $this->toBool($name, $value),
            self::INT    => $this->toInt($name, $value),
            self::STRING => (string) $value,
        };
    }

    private function toInt(string $name, mixed $value): int
    {
        if (!is_numeric($value)) {
            throw new \RuntimeException("Argument '{$name}' must be an integer");
        }

        return (int) $value;
    }

    private function toBool(string $name, mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
          ?? throw new \RuntimeException("Argument '{$name}' must be a boolean");
    }
}
