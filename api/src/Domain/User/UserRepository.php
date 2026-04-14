<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

interface UserRepository
{
    public function create(User $user): User;

    public function updateProfile(User $user): User;

    public function updatePassword(User $user): User;

    public function delete(int $id): void;

    public function findById(int $id): User;

    public function findByEmail(string $email): User;
}
