<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure;

use Hatepopcorn\Application\TestUseCase;
use Hatepopcorn\Infrastructure\Utils\Assert;

final class Container
{
    private static array $instances = [];
    private static array $bindings  = [];

    public static function bootstrap(array $bindings = []): void
    {
        $default = [
            TestUseCase::class => fn () => new TestUseCase(),
        ];
        self::$bindings = array_merge($default, $bindings);
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

        $factory = Assert::notNull(self::$bindings[$class], "[$class] factory");

        return self::$instances[$class] = $factory();
    }
}
