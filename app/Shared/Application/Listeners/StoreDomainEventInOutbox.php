<?php

declare(strict_types=1);

namespace App\Shared\Application\Listeners;

use App\Shared\Domain\Events\DomainEvent;
use App\Shared\Infrastructure\Persistence\Models\Outbox;

class StoreDomainEventInOutbox
{
    public function handle(DomainEvent $event): void
    {
        Outbox::create([
            'event_type' => $event::class,
            'payload' => json_decode(json_encode($event), true),
            'occurred_on' => $event->occurredOn,
        ]);
    }
}
