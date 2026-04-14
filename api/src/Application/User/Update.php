<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\User;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserPassword;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Container;
use Hatepopcorn\Infrastructure\HTTP\InputType;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

class Update implements UseCase
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = Container::get(UserRepository::class);
    }

    public function execute(Request $req): Response
    {
        $b    = $req->json();
        $user = new User(
            id: $req->getArg('id', InputType::INT),
            email: $b['email'],
            name: $b['name'],
            password: UserPassword::hash($b['password']),
            bio: $b['bio'],
        );

        return Response::json($user->jsonSerialize());
    }
}
