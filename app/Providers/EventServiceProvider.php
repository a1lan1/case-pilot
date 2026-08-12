<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Case\Application\Listeners\BroadcastCaseUpdate;
use App\Modules\Case\Application\Listeners\LogCaseStateTransition;
use App\Modules\Case\Domain\Events\CaseStatusChanged;
use App\Shared\Application\Listeners\StoreDomainEventInOutbox;
use App\Shared\Domain\Events\DomainEvent;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Override;
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

    /**
     * @throws BindingResolutionException
     */
    #[Override]
    public function boot(): void
    {
        parent::boot();

        $this->app->make('events')->listen(
            DomainEvent::class,
            StoreDomainEventInOutbox::class
        );
    }
}
