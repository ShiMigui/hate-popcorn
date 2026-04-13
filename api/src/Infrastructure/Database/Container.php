<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Domain\User\UserRepository;

class Container
{
    public static function get(string $class): object
    {
        return match ($class) {
            UserRepository::class => new PDOUserRepository(PDOConnection::get()),
            default               => throw new InvalidInputException("$class is not yet listed in Container!"),
        };
    }
}
