<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

use Hatepopcorn\Application\UseCase;

final class Routes
{
    public static function dispatch(): Response
    {
        $routes = [
            'POST' => [
                '/user' => \Hatepopcorn\Application\User\Create::class,
            ],
        ];

        $dispatcher = simpleDispatcher(
            fn ($r) => array_walk($routes,
                fn ($rs, $m) => array_walk($rs,
                    fn ($h, $route) => $r->addRoute($m, $route, $h)
                )
            )
        );

        try {
            [$status, $handler, $vars] = $dispatcher->dispatch(
                httpMethod: $_SERVER['REQUEST_METHOD'],
                uri: rawurldecode(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'))
            );

            return match ($status) {
                Dispatcher::NOT_FOUND          => Response::notFound(),
                Dispatcher::FOUND              => self::resolve($handler, $vars),
                default                        => Response::error('Internal Error'),
                Dispatcher::METHOD_NOT_ALLOWED => Response::error('Method Not Allowed', 405),
            };
        } catch (\Hatepopcorn\Domain\Exceptions\AppException $e) {
            return Response::error($e->getMessage(), $e->getHttpCode());
        } catch (\Throwable $e) {
            if ('dev' === strtolower($_ENV['APP_ENV'] ?? '')) {
                return Response::error($e->getMessage());
            }

            return Response::error('Internal Error');
        }
    }

    public static function resolve(string $class, array $vars): Response
    {
        if (!is_subclass_of($class, UseCase::class)) {
            return Response::error("Handler [$class] must implement UseCase");
        }

        $res = (new $class())->execute(new Request($vars));

        if (!$res instanceof Response) {
            return Response::error('Invalid response type');
        }

        return $res;
    }
}
