<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\Exceptions\EntityNotFoundException;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserId;
use Hatepopcorn\Domain\User\UserRepository;

final class PDOUserRepository extends PDORepository implements UserRepository
{
    public function create(User $user): User
    {
        $data = $this->fetch(
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password) RETURNING id, created_at',
            ['name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->password()->value]
        );

        return $user->markedAsPersisted($data['id'], $data['created_at']);
    }

    public function delete(UserId $id): void
    {
    }

    public function updateProfile(User $user): User
    {
        $this->prepare(
            'UPDATE TABLE users SET bio=:bio, name=:name, email=:email WHERE id = :id',
            ['name' => $user->getName(), 'bio' => $user->getBio(), 'email' => $user->getEmail(), 'id' => $user->getId()]
        );

        return $user;
    }

    public function updatePassword(User $user): User
    {
    }

    public function findById(int $id): User
    {
        $r = $this->fetch('SELECT * FROM users WHERE id = :id', ['id' => $id]);
        if (null === $r) {
            throw EntityNotFoundException::byId('User', $id);
        }

        return $this->mapUser($r);
    }

    public function findByEmail(string $email): User
    {
        $r = $this->fetch('SELECT * FROM users WHERE email = :email', ['email' => $email]);
        if (null === $r) {
            throw new EntityNotFoundException('User not found');
        }

        return $this->mapUser($r);
    }

    protected function mapUser(array $r): User
    {
        return User::fromPersistence(
            $r['id'],
            $r['name'],
            $r['password'],
            $r['email'],
            $r['role_id'],
            $r['bio'],
            $r['created_at'],
            $r['updated_at'],
        );
    }
}
