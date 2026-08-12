<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ApproveCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Specifications\CanApproveCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class ApproveCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    public function __invoke(ApproveCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanApproveCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $this->caseRepository->approve(
            $command->dto->id,
            $command->dto->version
        );
    }
}
