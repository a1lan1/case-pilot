<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ReviewCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Specifications\CanReviewCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class ReviewCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    public function __invoke(ReviewCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanReviewCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $this->caseRepository->review(
            $command->dto->id,
            $command->dto->version
        );
    }
}
