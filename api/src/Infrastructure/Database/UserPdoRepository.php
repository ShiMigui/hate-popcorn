<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Database;

use Hatepopcorn\Domain\Exceptions\Conflicts\AlreadyExistsException;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserId;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Domain\ValueObjects\Email;
use Hatepopcorn\Infrastructure\Exceptions\DatabaseException;

class UserPdoRepository extends PdoRepository implements UserRepository
{
    public function create(User $user): void
    {
        $sql = 'INSERT INTO users (name, email, password) VALUES (:n, :e, :p) RETURNING id, created_at';
        try {
            $data = $this->fetch($sql, [
                'n' => $user->name()->value,
                'e' => $user->email()->value,
                'p' => $user->password()->value,
            ]);
            $user->markAsPersisted($data['id'], $data['created_at'], $data['created_at']);
        } catch (DatabaseException $e) {
            throw match ($e->type) {
                PdoExceptionCodes::UNIQUE_VIOLATION => new AlreadyExistsException('User is already registered'),
                default                             => $e,
            };
        }
    }

    public function delete(UserId $id): void
    {
    }

    public function updateProfile(User $user): void
    {
    }

    public function updatePassword(User $user): void
    {
    }

    public function findByEmail(Email $email): User
    {
    }

    public function findById(UserId $id): User
    {
    }
}
