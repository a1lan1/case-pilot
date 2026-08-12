<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Rules;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Shared\Domain\Specifications\Rule;
use App\Shared\Domain\ValueObjects\UuidValueObject;

final readonly class CaseMustHaveAssigneeRule implements Rule
{
    public function __construct(
        private CaseEntity $case
    ) {}

    public function isSatisfied(): bool
    {
        return $this->case->assigneeId instanceof UuidValueObject;
    }

    public function getErrorMessage(): string
    {
        return 'Case must have an assigned employee to proceed.';
    }
}
