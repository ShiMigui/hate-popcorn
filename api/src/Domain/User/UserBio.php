<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\ValueObjects\LimitedString;

class UserBio extends LimitedString
{
    protected static ?int $max = 500;
}
