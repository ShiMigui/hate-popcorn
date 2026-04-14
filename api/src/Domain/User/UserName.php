<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\User;

use Hatepopcorn\Domain\ValueObjects\LimitedString;

final class UserName extends LimitedString
{
    protected static ?int $min = 5;
    protected static ?int $max = 100;
}
