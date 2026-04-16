<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;
use Hatepopcorn\Infrastructure\Utils\Assert;
use Hatepopcorn\Infrastructure\Utils\Caster;

/**
 * HTTP Request wrapper with type-safe input handling.
 *
 * Handles both route arguments and JSON request bodies with automatic
 * type casting and proper error handling.
 */
final class Request
{
    private ?array $body = null;

    /**
     * @param array<string, mixed> $arguments Route/query arguments
     */
    public function __construct(public readonly array $arguments)
    {
    }

    /**
     * Get a typed route/query argument.
     *
     * @param string $name Argument name
     * @param Caster $type Expected type
     *
     * @return mixed Casted value
     */
    public function arg(string $name, Caster $type): mixed
    {
        $argument = Assert::notNull($this->arguments[$name] ?? null, $name);

        return $type->cast($name, $argument);
    }

    /**
     * Get parsed JSON request body as array.
     *
     * @return array<string, mixed> Decoded JSON body
     */
    public function body(): array
    {
        if (null !== $this->body) {
            return $this->body;
        }

        $raw = file_get_contents('php://input');

        if (false === $raw || '' === $raw) {
            throw new InvalidTypeException('Request body is required');
        }

        try {
            $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new InvalidTypeException('Invalid JSON format', 400, previous: $e);
        }

        return $this->body = Caster::ARRAY->cast('body', $data);
    }

    /**
     * Get a nested value from JSON body using dot notation.
     *
     * @param string $path    Dot-separated path (e.g., "user.profile.name")
     * @param mixed  $default Default value if path not found
     *
     * @return mixed Value at path or default
     */
    public function bodyPath(string $path, mixed $default = null): mixed
    {
        $segments = explode('.', $path);
        $value    = $this->body();

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Get a typed nested value from JSON body.
     *
     * @param string $path    Dot-separated path
     * @param Caster $type    Expected type
     * @param mixed  $default Default value (must match the expected type)
     *
     * @return mixed Casted value
     */
    public function bodyParam(string $path, Caster $type, mixed $default = null): mixed
    {
        return $type->cast($path, $this->bodyPath($path, $default));
    }
}
