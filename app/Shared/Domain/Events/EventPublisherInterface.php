<?php

declare(strict_types=1);

namespace App\Shared\Domain\Events;

interface EventPublisherInterface
{
    /**
     * @param  array<string, mixed>  $payload
     */
    public function publish(string $eventType, array $payload): void;
}
