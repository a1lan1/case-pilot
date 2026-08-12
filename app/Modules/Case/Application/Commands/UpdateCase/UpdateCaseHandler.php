<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\UpdateCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Domain\States\Draft;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class UpdateCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    public function __invoke(UpdateCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);

        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        if ($case->status !== Draft::getMorphClass()) {
            throw new DomainException('Only draft cases can be updated.');
        }

        $case->version = $command->dto->version;
        $case->title = $command->dto->title;
        $case->description = $command->dto->description;
        $case->priority = $command->dto->priority;
        $case->type = $command->dto->type;
        $case->customerId = $command->dto->customerId;

        $this->caseRepository->save($case);
    }
}
