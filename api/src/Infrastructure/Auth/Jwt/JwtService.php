<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\Auth\Jwt;

interface JwtService
{
    public function generate(int $userId): string;

    public function decode(string $token): JwtPayload|false;
}
