<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Specifications;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\States\Approved;
use App\Modules\Case\Domain\States\Assigned;
use App\Modules\Case\Domain\States\Draft;
use App\Modules\Case\Domain\States\Submitted;
use App\Shared\Domain\Specifications\Specification;

final class CanCancelCaseSpecification implements Specification
{
    public function isSatisfiedBy(object $candidate): bool
    {
        if (! $candidate instanceof CaseEntity) {
            return false;
        }

        return in_array($candidate->status, [
            Draft::getMorphClass(),
            Submitted::getMorphClass(),
            Approved::getMorphClass(),
            Assigned::getMorphClass(),
        ], true);
    }

    public function getErrorMessage(): string
    {
        return 'Only draft, submitted, approved, or assigned cases can be cancelled.';
    }
}
