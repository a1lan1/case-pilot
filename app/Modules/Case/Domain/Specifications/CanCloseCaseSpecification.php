<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Specifications;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\States\Completed;
use App\Shared\Domain\Specifications\Specification;

final class CanCloseCaseSpecification implements Specification
{
    public function isSatisfiedBy(object $candidate): bool
    {
        if (! $candidate instanceof CaseEntity) {
            return false;
        }

        return $candidate->status === Completed::getMorphClass();
    }

    public function getErrorMessage(): string
    {
        return 'Only completed cases can be closed.';
    }
}
