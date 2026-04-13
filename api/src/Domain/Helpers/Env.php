<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Helpers;

use Hatepopcorn\Domain\Exceptions\EnvException;

final class Env
{
    public static function get(string $name)
    {
        return $_ENV[$name] ?? throw new EnvException($name);
    }
}
