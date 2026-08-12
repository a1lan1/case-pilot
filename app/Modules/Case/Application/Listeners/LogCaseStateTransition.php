<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Listeners;

use App\Modules\Case\Domain\Events\CaseStatusChanged;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseHistory;
use Illuminate\Support\Facades\Auth;
use Spatie\ModelStates\Events\StateChanged;
use Spatie\ModelStates\State;

class LogCaseStateTransition
{
    public function handle(StateChanged $event): void
    {
        $fromStatus = $event->initialState instanceof State ? (string) $event->initialState : null;
        $toStatus = (string) $event->finalState;

        CaseHistory::create([
            'case_id' => $event->model->id,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'user_id' => Auth::id(),
            'created_at' => now(),
        ]);

        event(new CaseStatusChanged(
            $event->model->id,
            $toStatus
        ));
    }
}
