<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\User;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;
use Hatepopcorn\Infrastructure\Utils\Caster;

class UserRegister implements UseCase
{
    public function __construct(private UserRepository $repo)
    {
    }

    public function execute(Request $req): Response
    {
        $o = User::aNew(
            $req->param('name', Caster::STRING),
            $req->param('email', Caster::STRING),
            $req->param('password', Caster::STRING)
        );
        $this->repo->create($o);

        return Response::json($o, 201);
    }
}
