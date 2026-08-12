<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\DeleteCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Shared\Domain\Exceptions\DomainException;

final readonly class DeleteCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository
    ) {}

    /**
     * @throws DomainException
     */
    public function __invoke(DeleteCaseCommand $command): void
    {
        $case = $this->caseRepository->find($command->dto->id);
        if (! $case instanceof CaseEntity) {
            throw new DomainException('Case not found.');
        }

        $this->caseRepository->delete($command->dto->id, $command->dto->version);
    }
}
