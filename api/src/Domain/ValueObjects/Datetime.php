<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidValueException;

final class Datetime extends ValueObject
{
    private const FORMAT                    = DATE_ATOM;
    private static ?\DateTimeZone $timeZone = null;

    public function __construct(?string $value = null)
    {
        self::$timeZone ??= new \DateTimeZone('UTC');
        try {
            parent::__construct(new \DateTimeImmutable($value ?? 'now', self::$timeZone));
        } catch (\Exception) {
            $value ??= 'null';
            throw new InvalidValueException("Invalid datetime: '$value'");
        }
    }

    public function format(): string
    {
        return $this->value->format(self::FORMAT);
    }

    public static function bindTimezone(\DateTimeZone $tz): void
    {
        self::$timeZone = $tz;
    }
}
