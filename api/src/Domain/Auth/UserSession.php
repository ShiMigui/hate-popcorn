<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Auth;

use Hatepopcorn\Domain\User\UserId;

class UserSession
{
    private UserId $userId;
    private RefreshToken $token;
    private \DateTimeImmutable $expiresAt;
    private \DateTimeImmutable $createdAt;

    private function __construct(
        UserId $id,
        RefreshToken $token,
        \DateTimeImmutable $expiresAt,
        \DateTimeImmutable $createdAt,
    ) {
        $this->userId    = $id;
        $this->token     = $token;
        $this->expiresAt = $expiresAt;
        $this->createdAt = $createdAt;
    }

    public static function createFor(UserId $userId): self
    {
        return new self(
            $userId,
            RefreshToken::generate(),
            new \DateTimeImmutable('+15 days'),
            new \DateTimeImmutable()
        );
    }

    public static function fromPersistence(int $userId, string $token, string $expiresAt, string $createdAt): self
    {
        return new self(
            new UserId($userId),
            new RefreshToken($token),
            new \DateTimeImmutable($expiresAt),
            new \DateTimeImmutable($createdAt),
        );
    }

    public function userId(): int
    {
        return $this->userId->value;
    }

    public function expiresAt(): string
    {
        return $this->expiresAt->format(DATE_ATOM);
    }

    public function createdAt(): string
    {
        return $this->createdAt->format(DATE_ATOM);
    }

    public function token(): string
    {
        return $this->token->get();
    }
}
