<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure;

use Hatepopcorn\Application\TestUseCase;
use Hatepopcorn\Application\User\UserRegister;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Database\PdoFactory;
use Hatepopcorn\Infrastructure\Database\UserPdoRepository;
use Hatepopcorn\Infrastructure\Utils\Assert;

final class Container
{
    private static array $instances = [];
    private static array $bindings  = [];

    public static function bootstrap(array $bindings = []): void
    {
        $default = [
            \PDO::class => fn () => PdoFactory::create(),

            UserRepository::class => fn () => new UserPdoRepository(self::get(\PDO::class)),

            TestUseCase::class  => fn () => new TestUseCase(),
            UserRegister::class => fn () => new UserRegister(self::get(UserRepository::class)),
        ];
        self::$bindings = array_merge($default, $bindings);
    }

    public static function get(string $class): object
    {
        if (isset(self::$instances[$class])) {
            return self::$instances[$class];
        }

        $factory = Assert::notNull(self::$bindings[$class], "[$class] factory");

        return self::$instances[$class] = $factory();
    }
}
