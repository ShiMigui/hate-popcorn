<?php

declare(strict_types=1);

namespace Hatepopcorn\Infrastructure\HTTP;

final class Response
{
    private function __construct(
        private int $status,
        private mixed $body = null,
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

    public static function json(mixed $body, int $status = 200): self
    {
        return new self($status, $body);
    }

    public static function noContent(): self
    {
        return new self(204);
    }

    public static function error(string $message, int $status = 500): self
    {
        return new self($status, ['error' => $message]);
    }

    public static function notFound(): self
    {
        return self::error('Not Found', 404);
    }
}
