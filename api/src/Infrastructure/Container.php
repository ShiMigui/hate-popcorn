<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure;

use Hatepopcorn\Domain\Auth\JwtService;
use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Domain\Helpers\Env;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Auth\FirebaseJwtService;
use Hatepopcorn\Infrastructure\Database\PDOConnection;
use Hatepopcorn\Infrastructure\Database\PDOUserRepository;

final class Container
{
    private static array $instances = [];
    private static array $bindings;

    public static function bootstrap(?array $bindings = null): void
    {
        self::$bindings = $bindings ?? [
            UserRepository::class => fn () => new PDOUserRepository(PDOConnection::get()),
            JwtService::class     => fn () => new FirebaseJwtService(Env::get('SECRET'), 1800),
        ];
    }

    public static function bind(string $abstract, callable $factory): void
    {
        self::$bindings[$abstract] = $factory;
    }

    public static function get(string $class): object
    {
        if (isset(self::$instances[$class])) {
            return self::$instances[$class];
        }

        $factory = InvalidInputException::notNullOrThrow(self::$bindings[$class], "Factory for $class");

        return self::$instances[$class] = $factory();
    }
}
