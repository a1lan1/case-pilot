<?php

declare(strict_types=1);

namespace App\Modules\Assignment\Infrastructure\Repositories;

use App\Modules\Assignment\Domain\Entities\AssigneeEntity;
use App\Modules\Assignment\Domain\Repositories\AssigneeRepositoryInterface;
use App\Shared\Domain\ValueObjects\UuidValueObject;

class InMemoryAssigneeRepository implements AssigneeRepositoryInterface
{
    private array $assignees = [];

    public function __construct()
    {
        $this->assignees[] = new AssigneeEntity(
            id: new UuidValueObject('a1b2c3d4-e5f6-7890-1234-567890abcdef'),
            name: 'John Doe',
            isAvailable: true,
        );
    }

    public function find(UuidValueObject $id): ?AssigneeEntity
    {
        return array_find(
            $this->assignees,
            fn($assignee): bool => $assignee->id->value === $id->value
        );
    }

    public function all(): array
    {
        return $this->assignees;
    }
}
