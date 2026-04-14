<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserRepository;

final class PDOUserRepository extends PDORepository implements UserRepository
{
    private const SELECT = 'SELECT * FROM users';

    public function save(User $user): User
    {
        $params = ['name' => $user->getName(), 'email' => $user->getEmail(), 'pass' => $user->getPassword()];
        if ($id = null !== $user->getId()) {
            return $user;
        }

        $sql  = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :pass) RETURNING id, created_at, updated_at;';
        $data = $this->fetch($sql, $params);

        $user->setId($data['id']);
        $user->syncCreatedAt($data['created_at']);
        $user->syncUpdatedAt($data['updated_at']);

        return $user;
    }

    public function delete(int $id): void
    {
    }

    public function findById(int $id): User
    {
        return new User(id: $id, name: '', email: '', password: '');
    }
}
