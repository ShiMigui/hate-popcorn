<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Auth;

use Hatepopcorn\Domain\ValueObjects\Token;

final class RefreshToken extends Token
{
    protected static int $chars = 64;
}
