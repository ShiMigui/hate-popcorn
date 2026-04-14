<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Auth\Jwt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class FirebaseJwtService implements JwtService
{
    private const ALGO = 'HS256';

    public function __construct(
        private string $secret,
        private int $ttl = 900,
    ) {
    }

    public function generate(int $userId): string
    {
        $now = time();

        $payload = [
            'sub' => $userId,
            'iat' => $now,
            'exp' => $now + $this->ttl,
        ];

        return JWT::encode($payload, $this->secret, self::ALGO);
    }

    public function decode(string $token): JwtPayload|false
    {
        try {
            $data = JWT::decode($token, new Key($this->secret, self::ALGO));

            return new JwtPayload(
                sub: $data->sub ?? throw new \UnexpectedValueException(),
                iat: $data->iat ?? throw new \UnexpectedValueException(),
                exp: $data->exp ?? throw new \UnexpectedValueException(),
            );
        } catch (\Throwable) {
            return false;
        }
    }
}
