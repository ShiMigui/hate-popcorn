<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Domain\ValueObjects\Email;

class User
{
    private UserName $name;
    private Email $email;
    private UserPassword $password;
    private ?UserId $id                    = null;
    private ?UserBio $bio                  = null;
    private UserRole $role                 = UserRole::USER;
    private ?\DateTimeImmutable $createdAt = null;
    private ?\DateTimeImmutable $updatedAt = null;
    // private string $imageHash; // For now, I won't implement this

    public function __construct(
        string $name,
        string $password,
        string $email,
        ?int $id = null,
        ?int $roleId = null,
        ?string $bio = null,
        ?string $createdAt = null,
        ?string $updatedAt = null,
    ) {
        $this->name     = UserName::from($name);
        $this->email    = Email::from($email);
        $this->password = UserPassword::from($password);

        if (null !== $roleId) {
            $this->role = UserRole::from($roleId);
        }
        if (null !== $id) {
            $this->id = UserId::from($id);
        }
        if (null !== $bio) {
            $this->bio = UserBio::from($bio);
        }
        if (null !== $createdAt) {
            $this->createdAt = new \DateTimeImmutable($createdAt);
        }
        if (null !== $updatedAt) {
            $this->updatedAt = new \DateTimeImmutable($updatedAt);
        }
    }

    public function toResponse(): array
    {
        return [
            'id'         => $this->getId(),
            'bio'        => $this->getBio(),
            'name'       => $this->getName(),
            'role'       => $this->role->toResponse(),
            'updated_at' => $this->getUpdatedAt(),
            'created_at' => $this->getCreatedAt(),
        ];
    }

    public function getId(): ?int
    {
        return $this->id?->get();
    }

    public function getRole(): int
    {
        return $this->role->value;
    }

    public function getName(): string
    {
        return $this->name->get();
    }

    public function getEmail(): string
    {
        return $this->email->get();
    }

    public function getBio(): ?string
    {
        return $this->bio?->get();
    }

    public function getPassword(): ?string
    {
        return $this->password?->get();
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt?->format(DATE_ATOM);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt?->format(DATE_ATOM);
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

    public function setId(int $id): void
    {
        if (null !== $this->id) {
            throw new InvalidInputException('Id cannot be changed');
        }
        $this->id = UserId::from($id);
    }

    public function syncUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = new \DateTimeImmutable($updatedAt);
    }

    public function syncCreatedAt(string $createdAt): void
    {
        $this->createdAt = new \DateTimeImmutable($createdAt);
    }
}
