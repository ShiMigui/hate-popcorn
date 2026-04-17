<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidValueException;

class Id extends ValueObject
{
    public function __construct(int $id)
    {
        if ($id < 1) {
            throw new InvalidValueException("{$this->name()} must be positive, got {$id}");
        }
        parent::__construct($id);
    }
}
