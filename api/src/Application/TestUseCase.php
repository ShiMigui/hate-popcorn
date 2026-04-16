<?php

declare(strict_types=1);

namespace Hatepopcorn\Application;

use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

class TestUseCase implements UseCase
{
    public function execute(Request $req): Response
    {
        return Response::json(['message' => 'Hello World']);
    }
}
