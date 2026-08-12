<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Specifications;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\States\UnderReview;
use App\Shared\Domain\Specifications\Specification;

final class CanApproveCaseSpecification implements Specification
{
    public function isSatisfiedBy(object $candidate): bool
    {
        if (! $candidate instanceof CaseEntity) {
            return false;
        }

        return $candidate->status === UnderReview::getMorphClass();
    }

    public function getErrorMessage(): string
    {
        return 'Only cases under review can be approved.';
    }
}
