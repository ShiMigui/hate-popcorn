<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

final class Request
{
    private ?array $json = null;

    /**
     * @param array<string,mixed> $args
     */
    public function __construct(private array $args)
    {
    }

    public function json(): array
    {
        return $this->json ??= $this->loadJson();
    }

    public function getArg(string $name, InputType $type): mixed
    {
        return $type->cast($name, $this->args[$name] ?? throw new \RuntimeException("Missing required argument: $name"));
    }

    private function loadJson(): array
    {
        $raw = file_get_contents('php://input');

        if (false === $raw || '' === $raw) {
            throw new \RuntimeException('Expected JSON body, none given');
        }

        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        return is_array($data) ? $data : throw new \RuntimeException('JSON body must decode to an array');
    }
}
