<?php

declare(strict_types=1);

namespace Hatepopcorn\Application;

use Hatepopcorn\Infrastructure\HTTP\Request;

interface UseCase
{
    public function execute(Request $req): void;
}
