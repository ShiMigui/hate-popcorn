<?php

declare(strict_types=1);

namespace Hatepopcorn\Domain\ValueObjects;

use Hatepopcorn\Domain\Exceptions\InvalidValueException;

class Varchar extends ValueObject
{
    public function __construct(
        string $value,
        protected readonly ?int $max = null,
        protected readonly int $min = 0,
        private ?string $label = null,
    ) {
        $this->label ??= static::name();
        $this->validate($value);
        parent::__construct($value);
    }

    final public static function normalizeSpaces(string $value): string
    {
        return preg_replace('/\s+/', ' ', trim($value));
    }

    final public static function normalized(string $value, ?int $max, int $min = 0, string $label): self
    {
        return new self(self::normalizeSpaces($value), $max, $min, $label);
    }

    private function validate(string $value): void
    {
        $len = mb_strlen($value);

        if (null !== $this->max && $len > $this->max) {
            throw new InvalidValueException("{$this->label} must have at most {$this->max} characters, got {$len}");
        }

        if ($len < $this->min) {
            throw new InvalidValueException("{$this->label} must have at least {$this->min} characters, got {$len}");
        }
    }
}
