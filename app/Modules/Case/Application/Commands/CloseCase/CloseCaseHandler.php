<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CloseCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\Specifications\CanCloseCaseSpecification;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class CloseCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    /**
     * @throws DomainException
     */
    public function __invoke(CloseCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $specification = new CanCloseCaseSpecification;
        if (! $specification->isSatisfiedBy($case)) {
            throw new DomainException($specification->getErrorMessage());
        }

        $this->caseRepository->close(
            $command->dto->id,
            $command->dto->version
        );
    }
}
