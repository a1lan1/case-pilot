<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\StartCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Rules\CaseMustHaveAssigneeRule;
use App\Modules\Case\Domain\Specifications\CanStartCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class StartCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    /**
     * @throws DomainException
     */
    public function __invoke(StartCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanStartCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $assigneeRule = new CaseMustHaveAssigneeRule($case);
        if (! $assigneeRule->isSatisfied()) {
            throw new DomainException($assigneeRule->getErrorMessage());
        }

        $this->caseRepository->start(
            $command->dto->id,
            $command->dto->version
        );
    }
}
