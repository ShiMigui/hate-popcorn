<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database\Pdo;

use Hatepopcorn\Infrastructure\Exceptions\DatabaseException;

abstract class PdoRepository
{
    final public function __construct(private \PDO $conn)
    {
    }

    public function query(string $query, array $params = [], array $passthroughErrors = []): \PDOStatement
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt;
        } catch (\PDOException $e) {
            if (isset($passthroughErrors[$e->getCode()])) {
                throw $e;
            }
            throw new DatabaseException($e);
        }
    }

    public function fetch(string $sql, array $data = [], array $passthroughErrors = []): ?array
    {
        $r = $this->query($sql, $data, $passthroughErrors)->fetch();

        return false === $r ? null : $r;
    }

    public function fetchAll(string $sql, array $data = [], array $passthroughErrors = []): array
    {
        return $this->query($sql, $data, $passthroughErrors)->fetchAll();
    }
}
