<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Specifications;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\States\Draft;
use App\Shared\Domain\Specifications\Specification;

final class CanSubmitCaseSpecification implements Specification
{
    public function isSatisfiedBy(object $candidate): bool
    {
        if (! $candidate instanceof CaseEntity) {
            return false;
        }

        return $candidate->status === Draft::getMorphClass();
    }

    public function getErrorMessage(): string
    {
        return 'Only draft cases can be submitted.';
    }
}
