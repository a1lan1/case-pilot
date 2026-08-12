<?php

declare(strict_types=1);

namespace App\Shared\Domain\Traits;

trait HasDomainEvents
{
    private array $domainEvents = [];

    public function record(object $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];

        return $events;
    }
}
