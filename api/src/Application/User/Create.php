<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\User;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\User;
use Hatepopcorn\Domain\User\UserPassword;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Database\Container;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

final class Create implements UseCase
{
    private UserRepository $repo;

    public function __construct(?UserRepository $repo = null)
    {
        $this->repo = $repo ?? Container::get(UserRepository::class);
    }

    public function execute(Request $req): Response
    {
        $body = $req->json();
        $user = $this->repo->save(new User(email: $body['email'], name: $body['name'], password: UserPassword::hash($body['password'])));

        return Response::json($user->toResponse());
    }
}
