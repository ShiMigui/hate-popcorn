<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

final class Response
{
    private function __construct(
        private ?array $body,
        private int $status,
    ) {
    }

    public function send(): void
    {
        http_response_code($this->status);

        if (null !== $this->body) {
            header('Content-Type: application/json');
            echo json_encode($this->body, JSON_THROW_ON_ERROR);
        }
    }

    public static function json(array $body, int $status = 200): self
    {
        return new self($body, $status);
    }

    public static function noContent(): self
    {
        return new self(null, 204);
    }

    public static function notFound(): self
    {
        return self::error('Not Found', 404);
    }

    public static function error(string $message, int $status = 500): self
    {
        return new self(['error' => $message], $status);
    }
}
