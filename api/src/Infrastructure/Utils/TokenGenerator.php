<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

final class TokenGenerator
{
    /**
     * @return string Hex-encoded token (length = $bytes * 2)
     */
    public static function generate(int $bytes): string
    {
        return bin2hex(random_bytes($bytes));
    }
}
