<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Auth\Jwt;

final class JwtPayload implements \JsonSerializable
{
    public function __construct(
        public readonly int $sub,
        public readonly int $iat,
        public readonly int $exp,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'sub' => $this->sub,
            'iat' => $this->iat,
            'exp' => $this->exp,
        ];
    }

    public function isExpired(): bool
    {
        return $this->exp < time();
    }
}
