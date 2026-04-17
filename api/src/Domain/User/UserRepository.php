<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\ValueObjects\Email;

interface UserRepository
{
    public function create(User $user): void; // register

    public function delete(UserId $id): void; // delete account

    public function updateProfile(User $user): void;

    public function updatePassword(User $user): void;

    // public function updateRole(User $user): void;

    public function findByEmail(Email $email): User; // login

    public function findById(UserId $id): User; // see profile
}
