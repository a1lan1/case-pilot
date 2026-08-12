<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Rules;

use App\Modules\Assignment\Domain\Entities\AssigneeEntity;
use App\Modules\Assignment\Domain\Repositories\AssigneeRepositoryInterface;
use App\Shared\Domain\Specifications\Rule;
use App\Shared\Domain\ValueObjects\UuidValueObject;

final readonly class AssigneeMustBeAvailableRule implements Rule
{
    public function __construct(
        private ?UuidValueObject $assigneeId,
        private AssigneeRepositoryInterface $assigneeRepository
    ) {}

    public function isSatisfied(): bool
    {
        if (! $this->assigneeId instanceof UuidValueObject) {
            return false;
        }

        $assignee = $this->assigneeRepository->find($this->assigneeId);

        return $assignee instanceof AssigneeEntity && $assignee->isAvailable;
    }

    public function getErrorMessage(): string
    {
        return 'The assigned employee must be available to proceed.';
    }
}
