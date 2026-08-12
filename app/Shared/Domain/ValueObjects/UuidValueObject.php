<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Stringable;

class UuidValueObject implements Stringable
{
    public function __construct(public readonly string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function random(): self
    {
        return new self(Str::uuid()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (! Str::isUuid($id)) {
            throw new InvalidArgumentException(sprintf('"%s" does not allow the value "%s".', static::class, $id));
        }
    }
}
