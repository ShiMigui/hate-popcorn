<?php

declare(strict_types=1);

namespace Hatepopcorn\Application\Auth;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\Exceptions\CredentialsException;
use Hatepopcorn\Domain\User\UserRepository;
use Hatepopcorn\Infrastructure\Auth\Jwt\JwtService;
use Hatepopcorn\Infrastructure\Container;
use Hatepopcorn\Infrastructure\HTTP\Request;
use Hatepopcorn\Infrastructure\HTTP\Response;

class Login implements UseCase
{
    private UserRepository $repo;
    private JwtService $jwtService;

    public function __construct()
    {
        $this->repo       = Container::get(UserRepository::class);
        $this->jwtService = Container::get(JwtService::class);
    }

    public function execute(Request $req): Response
    {
        $repo = $this->repo;
        $jwt  = $this->jwtService;

        $user     = $repo->findByEmail($req->getJson(['email']));
        $password = $req->getJson(['password']);
        if (!$user->passwordVerify($password)) {
            throw new CredentialsException();
        }

        if ($user->passwordNeedsRehash()) {

        }

        $access_token = $jwt->generate($user->getId());

        return Response::json([]);
    }
}
