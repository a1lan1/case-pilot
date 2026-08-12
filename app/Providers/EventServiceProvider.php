<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Case\Application\Listeners\BroadcastCaseUpdate;
use App\Modules\Case\Application\Listeners\LogCaseStateTransition;
use App\Modules\Case\Domain\Events\CaseStatusChanged;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Spatie\ModelStates\Events\StateChanged;

class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        StateChanged::class => [
            LogCaseStateTransition::class,
        ],
        CaseStatusChanged::class => [
            BroadcastCaseUpdate::class,
        ],
    ];
}
