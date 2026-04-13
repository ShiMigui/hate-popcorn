<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\Helpers\Env;

final class PDOConnection
{
    private static ?\PDO $instance = null;

    public static function get(): \PDO
    {
        return self::$instance ??= self::load();
    }

    private static function load(): \PDO
    {
        $host = Env::get('DB_HOST');
        $port = Env::get('DB_PORT');
        $name = Env::get('DB_NAME');
        $user = Env::get('DB_USER');
        $pass = Env::get('DB_PASS');
        $opts = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        return new \PDO("pgsql:host=$host;port=$port;dbname=$name;options='--client_encoding=UTF8'", $user, $pass, $opts);
    }
}
