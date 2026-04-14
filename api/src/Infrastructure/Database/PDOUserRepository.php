<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserRepository;

final class PDOUserRepository extends PDORepository implements UserRepository
{
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
        $r = $this->fetch('SELECT * FROM users WHERE id = :id', ['id' => $id]);

        return new User(
            name: $r['name'],
            email: $r['email'],
            password: $r['password'],
            id: $r['id'],
            roleId: $r['role_id'],
            bio: $r['bio'],
            createdAt: $r['created_at'],
            updatedAt: $r['updated_at'],
        );
    }
}
