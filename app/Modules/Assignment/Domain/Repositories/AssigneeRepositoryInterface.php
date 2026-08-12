<?php

declare(strict_types=1);

namespace App\Modules\Assignment\Domain\Repositories;

use App\Modules\Assignment\Domain\Entities\AssigneeEntity;
use App\Shared\Domain\ValueObjects\UuidValueObject;

interface AssigneeRepositoryInterface
{
    public function find(UuidValueObject $id): ?AssigneeEntity;

    /**
     * @return array<int, AssigneeEntity>
     */
    public function all(): array;
}
