<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use FastRoute\Dispatcher;

use function FastRoute\simpleDispatcher;

final class Routes
{
    public static function dispatch(): Response
    {
        $routes = [
            'GET' => [
                '/' => fn () => Response::json(['message' => 'Hello World']),
            ],
        ];

        $uri    = rawurldecode(strtok($_SERVER['REQUEST_URI'] ?? '/', '?'));
        $method = $_SERVER['REQUEST_METHOD'];

        $dispatcher = simpleDispatcher(
            fn ($r) => array_walk($routes,
                fn ($rs, $m) => array_walk($rs,
                    fn ($h, $route) => $r->addRoute($m, $route, $h)
                )
            )
        );

        try {
            [$status, $handler, $vars] = $dispatcher->dispatch($method, $uri);

            return match ($status) {
                Dispatcher::FOUND => ($res = $handler(new Request($vars))) instanceof Response
                        ? $res
                        : Response::error('Invalid response', 500),
                Dispatcher::NOT_FOUND          => Response::notFound(),
                Dispatcher::METHOD_NOT_ALLOWED => Response::error('Method Not Allowed', 405),
                default                        => Response::error('Internal Error', 500),
            };
        } catch (\Hatepopcorn\Domain\Exceptions\AppException $e) {
            return Response::error($e->getMessage(), $e->getHttpCode());
        } catch (\Throwable $e) {
            if (isset($_ENV['APP_ENV']) && 'dev' === strtolower($_ENV['APP_ENV'])) {
                return Response::error($e->getMessage());
            }

            return Response::error('Internal Error');
        }
    }
}
