<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\User;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

class UserRegister implements UseCase
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function execute(Request $req): void
    {
        [$name, $email, $password] = $req->body()->listOf(['name', 'email', 'password']);

        $o = User::aNew($name, $email, $password);
        $this->repo->create($o);

        Response::json($o, 201);
    }
}
