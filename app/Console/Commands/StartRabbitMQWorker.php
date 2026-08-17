<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;

#[Description('Start consuming messages from RabbitMQ')]
#[Signature('rabbitmq:work {queue=default} {--timeout=60} {--tries=3}')]
class StartRabbitMQWorker extends Command
{
    public function handle(): int
    {
        $queue = $this->argument('queue');
        $timeout = $this->option('timeout');
        $tries = $this->option('tries');

        $this->info('Starting RabbitMQ worker for queue: '.$queue);
        $this->info(sprintf('Timeout: %ss, Max tries: %s', $timeout, $tries));

        // Listen to job events for logging
        Queue::looping(function (): void {
            $this->line('.');
        });

        Queue::failing(function (JobFailed $event): void {
            $this->error('Job failed: '.$event->job->resolveName());
            $this->error('Exception: '.$event->exception->getMessage());
        });

        // Start the worker
        $worker = $this->laravel['queue.worker'];

        return $worker->daemon(
            'rabbitmq',
            $queue,
            [
                'timeout' => $timeout,
                'tries' => $tries,
            ]
        );
    }
}
