<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

enum UserRole: int
{
    case USER  = 1;
    case ADMIN = 2;

    public function label(): string
    {
        return match ($this) {
            self::USER  => 'user',
            self::ADMIN => 'admin',
        };
    }

    public function toResponse(): array
    {
        return ['id' => $this->value, 'name' => $this->label()];
    }
}
