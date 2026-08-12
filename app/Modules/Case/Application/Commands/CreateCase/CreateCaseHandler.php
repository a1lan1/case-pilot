<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CreateCase;

use App\Modules\Case\Domain\Entities\CaseEntity;
use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Shared\Infrastructure\Metrics\Metrics;

final readonly class CreateCaseHandler
{
    public function __construct(
        private CaseRepositoryInterface $caseRepository,
        private Metrics $metrics,
    ) {}

    public function __invoke(CreateCaseCommand $command): void
    {
        $dto = $command->dto;

        $case = CaseEntity::create(
            title: $dto->title,
            description: $dto->description,
            priority: $dto->priority,
            type: $dto->type,
            customerId: $dto->customerId,
        );

        $this->caseRepository->save($case);

        $this->metrics->counter('cases_created_total', 'The total number of created cases.')->inc();
    }
}
