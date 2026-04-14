<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

interface UserRepository
{
    public function save(User $user): User;

    public function delete(int $id): void;

    public function findById(int $id): User;
}
