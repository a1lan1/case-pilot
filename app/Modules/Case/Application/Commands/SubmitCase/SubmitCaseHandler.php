<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\SubmitCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Specifications\CanSubmitCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class SubmitCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    public function __invoke(SubmitCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanSubmitCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $this->caseRepository->submit(
            $command->dto->id,
            $command->dto->version
        );
    }
}
