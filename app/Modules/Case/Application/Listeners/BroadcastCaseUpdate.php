<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Listeners;

use App\Modules\Case\Domain\Events\CaseStatusChanged;
use App\Modules\Case\Domain\Events\CaseUpdatedForBroadcast;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;

class BroadcastCaseUpdate
{
    public function handle(CaseStatusChanged $event): void
    {
        $case = CaseModel::find($event->caseId);

        if (! $case) {
            return;
        }

        broadcast(new CaseUpdatedForBroadcast(
            caseId: $case->id,
            caseData: $case->toArray()
        ))->toOthers();
    }
}
