<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

final class Datetime extends ValueObject
{
    private const format = DATE_ATOM;

    public function __construct(string $date)
    {
        parent::__construct(new \DateTimeImmutable($date));
    }

    public function __toString(): string
    {
        return $this->format();
    }

    public function format(): string
    {
        return $this->value->format(self::format);
    }
}
