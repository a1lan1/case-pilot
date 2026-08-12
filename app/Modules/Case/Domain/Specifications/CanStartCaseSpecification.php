<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Specifications;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\States\Assigned;
use App\Shared\Domain\Specifications\Specification;

final class CanStartCaseSpecification implements Specification
{
    public function isSatisfiedBy(object $candidate): bool
    {
        if (! $candidate instanceof CaseEntity) {
            return false;
        }

        return $candidate->status === Assigned::getMorphClass();
    }

    public function getErrorMessage(): string
    {
        return 'Only assigned cases can be started.';
    }
}
