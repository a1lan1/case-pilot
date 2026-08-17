<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\RabbitMQ;

use Illuminate\Queue\QueueManager;

class RabbitMQPublisher
{
    public function __construct(private readonly QueueManager $queue) {}

    public function publish(string $queue, array $message): bool
    {
        $this->queue->connection('rabbitmq')
            ->pushRaw(json_encode($message), $queue);

        return true;
    }

    public function publishWithRetry(string $queue, array $message, int $attempts = 3, int $delay = 60): bool
    {
        $this->queue->connection('rabbitmq')
            ->pushRaw(json_encode($message), $queue, [
                'attempts' => $attempts,
                'delay' => $delay,
            ]);

        return true;
    }
}
