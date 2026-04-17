<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidValueException;

final class Password extends Varchar
{
    private const ALGO    = PASSWORD_ARGON2ID;
    private const OPTIONS = [
        'memory_cost' => 65536, // 1 << 16 = 64 MB
        'time_cost'   => 3,
        'threads'     => 2,
    ];

    public function __construct(string $hash)
    {
        if (!password_get_info($hash)['algo']) {
            throw new InvalidValueException('Password must be encrypted');
        }
        parent::__construct($hash, 255, 0, 'Password');
    }

    public static function encrypt(string $plain): static
    {
        $plain = trim($plain);
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/', $plain)) {
            throw new InvalidValueException('Invalid password format');
        }

        return new static(password_hash($plain, self::ALGO, self::OPTIONS));
    }

    public function verify(string $input): bool
    {
        return password_verify(trim($input), $this->value);
    }

    public function needsRehash(): bool
    {
        return password_needs_rehash($this->value, self::ALGO, self::OPTIONS);
    }
}
