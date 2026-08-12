<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CancelCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Specifications\CanCancelCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class CancelCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    public function __invoke(CancelCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanCancelCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $this->caseRepository->cancel(
            $command->dto->id,
            $command->dto->version
        );
    }
}
