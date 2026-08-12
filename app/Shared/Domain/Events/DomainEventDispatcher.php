<?php

declare(strict_types=1);

namespace App\Shared\Domain\Events;

use Illuminate\Contracts\Events\Dispatcher;

class DomainEventDispatcher
{
    public function __construct(private readonly Dispatcher $dispatcher) {}

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event);
        }
    }
}
