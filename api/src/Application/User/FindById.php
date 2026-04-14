<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\User;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Container;
use Hatepopcorn\Infrastructure\HTTP\InputType;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

class FindById implements UseCase
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = Container::get(UserRepository::class);
    }

    public function execute(Request $req): Response
    {
        $user = $this->repo->findById($req->getArg('id', InputType::INT));

        return Response::json($user->jsonSerialize());
    }
}
