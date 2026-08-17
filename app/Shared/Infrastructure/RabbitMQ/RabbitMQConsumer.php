<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\RabbitMQ;

use Symfony\Component\Process\Process;

class RabbitMQConsumer
{
    /**
     * Start consuming messages from RabbitMQ
     *
     * Usage in console command:
     * $consumer = new RabbitMQConsumer();
     * $consumer->consume('notifications', 60, 3);
     */
    public function consume(?string $queue = null, int $timeout = 60, int $maxAttempts = 3): void
    {
        $process = new Process([
            'php',
            'artisan',
            'queue:work',
            'rabbitmq',
            '--queue='.($queue ?? 'default'),
            '--timeout='.$timeout,
            '--tries='.$maxAttempts,
        ]);

        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });
    }

    /**
     * Consumer with Dead Letter Queue support
     */
    public function consumeWithDLQ(?string $queue = null, int $timeout = 60): void
    {
        $process = new Process([
            'php',
            'artisan',
            'queue:work',
            'rabbitmq',
            '--queue='.($queue ?? 'default'),
            '--timeout='.$timeout,
            '--tries=3',
            '--backoff=60,300,900',
        ]);

        $process->run(function ($type, $buffer): void {
            echo $buffer;
        });
    }
}
