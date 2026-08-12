<?php

declare(strict_types=1);

namespace App\Modules\Assignment\Domain\Entities;

use App\Shared\Domain\ValueObjects\UuidValueObject;

final class AssigneeEntity
{
    public function __construct(
        public readonly UuidValueObject $id,
        public string $name,
        public bool $isAvailable,
    ) {}
}
