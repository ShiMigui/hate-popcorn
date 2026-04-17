<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Utils;

use Hatepopcorn\Infrastructure\Exceptions\InfrastructureException;

final class Environment
{
    private static ?bool $appEnv = null;

    /**
     * Get a required environment variable.
     *
     * Throws an exception if the variable is not defined. Use this for
     * critical configuration values that must exist (e.g., database credentials,
     * API keys, secret tokens).
     */
    public static function expected(string $name): mixed
    {
        return $_ENV[$name] ?? throw new InfrastructureException("Environment variable '$name' not set");
    }

    /**
     * Get a environment variable or provided default value.
     */
    public static function getOr(string $name, mixed $default): mixed
    {
        return $_ENV[$name] ?? $default;
    }

    /**
     * Check if application is running in development mode.
     *
     * @return bool APP_ENV equals 'dev'
     */
    public static function isDevMode(): bool
    {
        return self::$appEnv ??= ('dev' === strtolower($_ENV['APP_ENV'] ?? ''));
    }
}
