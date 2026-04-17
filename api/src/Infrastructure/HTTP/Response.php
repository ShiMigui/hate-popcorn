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
        exit;
    }

    public static function json(mixed $body, int $status = 200): void
    {
        new self($status, $body)->send();
    }

    public static function noContent(): void
    {
        new self(204)->send();
    }

    public static function error(string $message, int $status = 500): void
    {
        new self($status, ['error' => $message])->send();
    }

    public static function notFound(): void
    {
        self::error('Not Found', 404);
    }
}
