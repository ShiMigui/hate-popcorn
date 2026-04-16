<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

use Hatepopcorn\Application\UseCase;
use Hatepopcorn\Domain\Exceptions\DomainException;
use Hatepopcorn\Infrastructure\Container;
use Hatepopcorn\Infrastructure\Exceptions\InfrastructureException;
use Hatepopcorn\Infrastructure\Utils\Environment;

final class Routes
{
    public const routes = [
        'GET' => ['/' => \Hatepopcorn\Application\TestUseCase::class],
    ];

    public static function dispatch(): Response
    {
        try {
            $info = self::makeDispatcher(self::routes)->dispatch(
                $_SERVER['REQUEST_METHOD'],
                rawurldecode(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'))
            );

            return match ($info[0]) {
                Dispatcher::METHOD_NOT_ALLOWED => Response::error('Method Not Allowed', 405),
                Dispatcher::NOT_FOUND          => Response::notFound(),
                Dispatcher::FOUND              => self::resolve($info[1], $info[2]),
                default                        => Response::error('Internal Error'),
            };
        } catch (DomainException $e) {
            return Response::error($e->getMessage(), $e->getHttpCode());
        } catch (InfrastructureException $e) {
            $message = $e->getMessage();

            if (Environment::isDevMode()) {
                if (null === $e->getPrevious()) {
                    echo $e->getTraceAsString();
                    exit;
                }
                $message .= ": {$e->getPrevious()->getMessage()}";
            }

            return Response::error($message);
        } catch (\Throwable $e) {
            return Response::error(Environment::isDevMode() ? $e->getMessage() : 'Internal Error');
        }
    }

    private static function makeDispatcher(array $routes): Dispatcher
    {
        return simpleDispatcher(
            fn ($r) => array_walk($routes,
                fn ($rs, $m) => array_walk($rs,
                    fn ($h, $route) => $r->addRoute($m, $route, $h)
                )
            )
        );
    }

    private static function resolve(string $handler, array $vars): Response
    {
        $useCase = Container::get($handler);

        return $useCase instanceof UseCase
          ? $useCase->execute(new Request($vars))
          : Response::error("[$handler] must implement [UseCase]");
    }
}
