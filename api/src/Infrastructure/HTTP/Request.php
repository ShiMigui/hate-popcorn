<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use Hatepopcorn\Domain\Exceptions\InvalidInputException;

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
        return $type->cast($name, $this->getFrom($this->args, $name));
    }

    public function getJson(array $keys, InputType $type = InputType::STRING): mixed
    {
        try {
            $value = $this->json();

            foreach ($keys as $k) {
                $value = $this->getFrom($value, $k);
            }
        } catch (\TypeError) {
            throw new InvalidInputException('Invalid JSON structure');
        }

        return $type->cast(end($keys), $value);
    }

    private function loadJson(): array
    {
        $raw = file_get_contents('php://input');

        if (false === $raw || '' === $raw) {
            throw new InvalidInputException('Expected JSON body, none given');
        }

        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);

        return is_array($data) ? $data : throw new InvalidInputException('JSON body must decode to an array');
    }

    private function getFrom(array $source, string $name): mixed
    {
        return InvalidInputException::notNullOrThrow($source[$name], $name);
    }
}
