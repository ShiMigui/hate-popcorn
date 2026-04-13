<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\Exceptions;

final class EntityNotFoundException extends AppException
{
    public function __construct(string $message = 'Entity not found')
    {
        parent::__construct($message, 404);
    }

    public static function byId(string $entity, mixed $id): self
    {
        return new self("$entity with id '$id' not found!");
    }
}
