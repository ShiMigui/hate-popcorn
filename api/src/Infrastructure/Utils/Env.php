<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Domain\Exceptions\EnvException;

final class Env
{
    public static function get(string $name): mixed
    {
        return $_ENV[$name] ?? throw new EnvException($name);
    }

    public static function isDevEnv(): bool
    {
        return 'dev' === strtolower($_ENV['APP_ENV'] ?? '');
    }
}
