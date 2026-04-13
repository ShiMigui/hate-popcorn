<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

class PDORepository
{
    public function __construct(private \PDO $conn)
    {
    }

    public function prepare(string $query, array $params = []): \PDOStatement
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }

    public function fetch(string $query, array $params = []): array
    {
        $stmt = $this->prepare($query, $params);

        return $stmt->fetch();
    }

    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->prepare($query, $params);

        return $stmt->fetchAll();
    }
}
