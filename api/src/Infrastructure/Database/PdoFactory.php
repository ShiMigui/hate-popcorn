<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Infrastructure\Exceptions\DatabaseException;
use Hatepopcorn\Infrastructure\Utils\Environment;

class PdoFactory
{
    protected const OPTS = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    private function __construct()
    {
    }

    public static function create(
        ?string $host = null,
        ?string $port = null,
        ?string $name = null,
        ?string $user = null,
        ?string $pass = null,
    ): \PDO {
        $host ??= Environment::expected('DB_HOST');
        $port ??= Environment::expected('DB_PORT');
        $name ??= Environment::expected('DB_NAME');
        $user ??= Environment::expected('DB_USER');
        $pass ??= Environment::expected('DB_PASS');

        try {
            return new \PDO("pgsql:host=$host;port=$port;dbname=$name;", $user, $pass, static::OPTS);
        } catch (\Throwable $th) {
            throw new DatabaseException($th);
        }
    }
}
