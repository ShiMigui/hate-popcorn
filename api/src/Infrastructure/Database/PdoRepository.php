<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Infrastructure\Exceptions\DatabaseException;

abstract class PdoRepository
{
    final public function __construct(private \PDO $conn)
    {
    }

    public function query(string $query, array $params = []): \PDOStatement
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt;
        } catch (\PDOException $e) {
            throw new DatabaseException($e, 'Database error');
        }
    }

    public function fetch(string $sql, array $data = []): ?array
    {
        $r = $this->query($sql, $data)->fetch();

        return false === $r ? null : $r;
    }

    public function fetchAll(string $sql, array $data = []): array
    {
        return $this->query($sql, $data)->fetchAll();
    }
}
