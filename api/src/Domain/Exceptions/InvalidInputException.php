<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class InvalidInputException extends AppException
{
    public function __construct(string $input)
    {
        parent::__construct("Invalid input: $input", 400);
    }

    public static function nullOrThrow(mixed $v, string $field): void
    {
        $v ?? throw new static("$field must be null");
    }

    public static function notNullOrThrow(mixed $v, string $field): mixed
    {
        $v ?? throw new static("$field should not be null");

        return $v;
    }
}
