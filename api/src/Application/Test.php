<?php

declare(strict_types=1);

namespace Hatepopcorn\Application;

use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserPassword;
use Hatepopcorn\Domain\User\UserRole;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

final class Test implements UseCase
{
    public function execute(Request $req): Response
    {
        $user = new User(
            1,
            UserRole::ADMIN->value,
            'Miguel Nascimento',
            UserPassword::hash('StrongPass123')->get(),
            'Software developer who definitely enjoys debugging at 3AM.',
            'miguel@example.com',
            '2026-04-13 13:00:00+00',
            '2026-04-13 13:10:00+00'
        );

        return Response::json($user->toResponse());
    }
}
