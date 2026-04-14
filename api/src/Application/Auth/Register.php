<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\Auth;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserPassword;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Container;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

final class Register implements UseCase
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = Container::get(UserRepository::class);
    }

    public function execute(Request $req): Response
    {
        $body = $req->json();
        $user = User::create($body['name'], $body['email'], UserPassword::hash($body['password']));
        $this->repo->create($user);

        return Response::json($user->jsonSerialize());
    }
}
