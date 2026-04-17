<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

use Hatepopcorn\Domain\Exceptions\InvalidTypeException;

/**
 * HTTP Request wrapper with type-safe input handling.
 *
 * Provides a unified API to access:
 * - Route/query arguments
 * - JSON request body
 * - Nested values via dot notation
 *
 * Includes automatic type casting and fail-fast validation using domain exceptions.
 */
final class Request
{
    public readonly Parameters $arguments;
    private ?Parameters $body = null;

    public function __construct(array $vars)
    {
        $this->arguments = Parameters::of($vars);
    }

    public function body(): Parameters
    {
        if (null === $this->body) {
            $raw = file_get_contents('php://input');

            if (false === $raw || '' === $raw) {
                throw new InvalidTypeException('Request body is required');
            }

            try {
                return $this->body = Parameters::of(json_decode($raw, true, 512, JSON_THROW_ON_ERROR));
            } catch (\JsonException $e) {
                throw new InvalidTypeException('Invalid JSON format', 0, $e);
            }
        }

        return $this->body;
    }
}
