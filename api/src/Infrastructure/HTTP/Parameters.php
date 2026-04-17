<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use Hatepopcorn\Infrastructure\Utils\Assert;
use Hatepopcorn\Infrastructure\Utils\Converter;
use Hatepopcorn\Infrastructure\Utils\Type;

class Parameters
{
    private function __construct(private array $body, private string $currentPath = '')
    {
    }

    public static function of(array $body): static
    {
        return new static($body);
    }

    public function sub(string $name): static
    {
        return new static($this->get($name, Type::ARRAY), "{$this->currentPath}{$name}.");
    }

    public function get(string $key, Type $type = Type::STRING): mixed
    {
        $path = "{$this->currentPath}$key";

        return Converter::cast(Assert::keyNotNull($this->body, $key, $path), $path, $type);
    }

    public function listOf(array $values, Type $type = Type::STRING): array
    {
        return array_map(fn ($v) => $this->get($v, $type), $values);
    }

    public function mapOf(array $values): array
    {
        $result       = [];
        $stringCaster = Type::STRING;

        foreach ($values as $key => $config) {
            $result[$key] = $this->get($config[0], $config[1] ?? $stringCaster);
        }

        return $result;
    }
}
