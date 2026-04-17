<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;
use Hatepopcorn\Domain\Exceptions\InvalidValueException;
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
     * Get a typed nested value from JSON body.
     *
     * @param string $path Dot-separated path
     * @param Caster $type Expected type
     *
     * @return mixed Casted value
     */
    public function param(string $path, Caster $type): mixed
    {
        $parts       = explode('.', $path);
        $value       = $this->body();
        $currentPath = '';

        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                throw new InvalidValueException("$currentPath$part not provided");
            }
            $value = $value[$part];
            $currentPath .= "$part.";
        }

        return $type->cast($path, $value);
    }
}
