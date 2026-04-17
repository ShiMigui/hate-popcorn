<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

enum UserRole: int
{
    case USER  = 1;
    case ADMIN = 2;

    public function label(): string
    {
        return $this->name;
    }
}
