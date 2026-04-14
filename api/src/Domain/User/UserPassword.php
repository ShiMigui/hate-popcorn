<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;
use Hatepopcorn\Domain\ValueObjects\ValueObject;

final class UserPassword extends ValueObject
{
    private const ALGO = PASSWORD_ARGON2ID;

    private const OPTIONS = [
        'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
        'time_cost'   => PASSWORD_ARGON2_DEFAULT_TIME_COST,
        'threads'     => PASSWORD_ARGON2_DEFAULT_THREADS,
    ];

    public function __construct(string $hash)
    {
        if (0 === password_get_info($hash)['algo']) {
            throw new InvalidInputException('Invalid password hash.');
        }

        parent::__construct($hash);
    }

    public static function hash(string $plain): string
    {
        self::validate($plain = trim($plain));
        if ($hash = password_hash($plain, self::ALGO, self::OPTIONS)) {
            return $hash;
        }
        throw new \RuntimeException('Failed to hash password.');
    }

    public function verify(string $plain): bool
    {
        return password_verify($plain, $this->get());
    }

    public function needsRehash(): bool
    {
        return password_needs_rehash($this->get(), self::ALGO, self::OPTIONS);
    }

    /**
     * Validates a plain text password, a password valid must meet the following requirements:
     *  - Should have at least 8 chars long
     *  - Should contain at least one UPPERCASE char
     *  - Should contain at least one LOWERCASE char
     *  - Should contain at least one number.
     *
     * @throws InvalidInputException
     * */
    private static function validate(string $plain): void
    {
        if (mb_strlen($plain) < 8 || !preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $plain)) {
            throw new InvalidInputException('Invalid password format.');
        }
    }
}
