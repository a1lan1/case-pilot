<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Events;

use App\Shared\Domain\Events\DomainEvent;

class CaseCompleted extends DomainEvent
{
    public function __construct(
        public readonly int $caseId,
        public readonly string $caseNumber,
    ) {
        parent::__construct();
    }
}
