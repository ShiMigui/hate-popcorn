<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Domain\ValueObjects\Datetime;
use Hatepopcorn\Domain\ValueObjects\Email;

final class User implements \JsonSerializable
{
    private ?UserId $id;
    private Email $email;
    private UserBio $bio;
    private UserName $name;
    private UserRole $role;
    private UserPassword $password;
    private ?Datetime $updatedAt;
    private ?Datetime $createdAt;
    // private string $imageHash; // For now, I won't implement this

    private function __construct(
        string $name,
        string $password,
        string $email,
        int $roleId = 1,
        string $bio = '',
        ?UserId $id = null,
        ?Datetime $createdAt = null,
        ?Datetime $updatedAt = null,
    ) {
        $this->name     = UserName::from($name);
        $this->email    = Email::from($email);
        $this->password = UserPassword::from($password);
        $this->role     = UserRole::from($roleId);
        $this->bio      = UserBio::from($bio);

        $this->id        = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function fromPersistence(
        int $id,
        string $name,
        string $email,
        string $password,
        int $roleId,
        string $bio,
        string $createdAt,
        string $updatedAt,
    ): self {
        $created = Datetime::from($createdAt);
        $updated = Datetime::from($updatedAt);
        $userId  = UserId::from($id);

        return new static($name, $password, $email, $roleId, $bio, $userId, $created, $updated);
    }

    public static function create(string $name, string $email, string $password): static
    {
        return new static($name, $password, $email);
    }

    public function markedAsPersisted(int $id, string $createdAt): self
    {
        InvalidInputException::nullOrThrow($id, 'User id');
        $this->id        = UserId::from($id);
        $this->createdAt = Datetime::from($createdAt);
        $this->updatedAt = $this->createdAt;

        return $this;
    }

    public function createdAt(): Datetime
    {
        return $this->createdAt;
    }

    public function updatedAt(): Datetime
    {
        return $this->updatedAt;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function getId(): int
    {
        return $this->id->value;
    }

    public function getEmail(): string
    {
        return $this->email->value;
    }

    public function getName(): string
    {
        return $this->name->value;
    }

    public function getBio(): string
    {
        return $this->bio->value;
    }

    public function changeName(string $name): void
    {
        $this->name = UserName::from($name);
    }

    public function changeEmail(string $email): void
    {
        $this->email = Email::from($email);
    }

    public function changeBio(string $bio): void
    {
        $this->bio = UserBio::from($bio);
    }

    public function changePassword(string $hash): void
    {
        $this->password = UserPassword::from($hash);
    }

    public function changeRole(int $roleId): void
    {
        $this->role = UserRole::from($roleId);
    }

    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->id->value,
            'bio'  => $this->bio->value,
            'name' => $this->name->value,
            'role' => [
                'id'   => $this->role->value,
                'name' => $this->role->label(),
            ],
            'updated_at' => $this->updatedAt->format(),
            'created_at' => $this->createdAt->format(),
        ];
    }
}
