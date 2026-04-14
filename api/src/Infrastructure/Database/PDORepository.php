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

        if (false === $stmt) {
            throw new \RuntimeException('Failed to prepare statement');
        }

        if (!$stmt->execute($params)) {
            throw new \RuntimeException('Failed to execute statement');
        }

        return $stmt;
    }

    public function fetch(string $query, array $params = []): ?array
    {
        $stmt = $this->prepare($query, $params);

        return false === ($result = $stmt->fetch()) ? null : $result;
    }

    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->prepare($query, $params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
