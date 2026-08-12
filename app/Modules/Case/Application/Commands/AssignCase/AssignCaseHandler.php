<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\AssignCase;

use App\Modules\Assignment\Domain\Events\CaseAssignedToAgent;
use App\Modules\Assignment\Domain\Repositories\AssigneeRepositoryInterface;
use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Rules\AssigneeMustBeAvailableRule;
use App\Modules\Case\Domain\Specifications\CanAssignCaseSpecification;
use App\Shared\Domain\Events\DomainEventDispatcher;
use App\Shared\Domain\Exceptions\DomainException;
use App\Shared\Domain\ValueObjects\UuidValueObject;

final readonly class AssignCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository,
        private AssigneeRepositoryInterface $assigneeRepository,
        private DomainEventDispatcher $dispatcher,
    ) {}

    public function __invoke(AssignCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanAssignCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $assigneeRule = new AssigneeMustBeAvailableRule(
            new UuidValueObject($command->dto->assigneeId),
            $this->assigneeRepository
        );

        if (! $assigneeRule->isSatisfied()) {
            throw new DomainException($assigneeRule->getErrorMessage());
        }

        $this->caseRepository->assign(
            $command->dto->id,
            $command->dto->version,
            $command->dto->assigneeId
        );

        $this->dispatcher->dispatch([
            new CaseAssignedToAgent(
                caseId: $command->dto->id,
                assigneeId: $command->dto->assigneeId,
            ),
        ]);
    }
}
