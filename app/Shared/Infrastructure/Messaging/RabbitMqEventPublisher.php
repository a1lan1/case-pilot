<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Messaging;

use App\Shared\Domain\Events\EventPublisherInterface;
use Illuminate\Contracts\Queue\Queue;
use JsonException;

final readonly class RabbitMqEventPublisher implements EventPublisherInterface
{
    public function __construct(private Queue $queue) {}

    /**
     * @param  array<string, mixed>  $payload
     *
     * @throws JsonException
     */
    public function publish(string $eventType, array $payload): void
    {
        $message = json_encode([
            'type' => $eventType,
            'payload' => $payload,
        ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES);

        $this->queue->pushRaw($message, 'outbox');
    }
}
