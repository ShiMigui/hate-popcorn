<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Hatepopcorn\Infrastructure\Container::bootstrap();
Hatepopcorn\Infrastructure\HTTP\Routes::dispatch();
