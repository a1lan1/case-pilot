<?php

declare(strict_types=1);

namespace App\Modules\Assignment\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;

class CaseAssignedToAgent extends DomainEvent
{
    public function __construct(
        public readonly int $caseId,
        public readonly string $assigneeId,
    ) {
        parent::__construct();
    }
}
