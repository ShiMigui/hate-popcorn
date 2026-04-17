<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\ValueObjects\Datetime;
use Hatepopcorn\Domain\ValueObjects\Email;
use Hatepopcorn\Domain\ValueObjects\Password;
use Hatepopcorn\Domain\ValueObjects\Varchar;
use Hatepopcorn\Infrastructure\Utils\Assert;

trait UserAttributes
{
    private ?UserId $id;
    private Varchar $name;
    private Varchar $bio;
    private Email $email;
    private Password $password;
    private UserRole $role;
    private ?Datetime $createdAt;
    private ?Datetime $updatedAt;
    // I won't implement image_hash yet

    public function changeName(string $name): void
    {
        $this->name = Varchar::normalized($name, 'User name', 100, 5);
    }

    public function changeBio(string $bio): void
    {
        $this->bio = Varchar::normalized($bio, 'User bio', 500, 0);
    }

    public function changeEmail(string $email): void
    {
        $this->email = Email::from($email);
    }

    public function changePassword(string $password): void
    {
        $this->password = Password::from($password);
    }

    public function syncUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = Datetime::from($updatedAt);
    }

    public function id(): UserId
    {
        return Assert::notNull($this->id, 'User id');
    }

    public function name(): Varchar
    {
        return $this->name;
    }

    public function bio(): Varchar
    {
        return $this->bio;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): Password
    {
        return $this->password;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function createdAt(): Datetime
    {
        return Assert::notNull($this->createdAt, 'User created at');
    }

    public function updatedAt(): Datetime
    {
        return Assert::notNull($this->updatedAt, 'User updated at');
    }
}
