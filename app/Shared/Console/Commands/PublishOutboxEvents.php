<?php

declare(strict_types=1);

namespace App\Shared\Console\Commands;

use App\Shared\Domain\Events\EventPublisherInterface;
use App\Shared\Infrastructure\Persistence\Models\Outbox;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Throwable;

#[Description('Publish outbox events to RabbitMQ')]
#[Signature('outbox:publish')]
class PublishOutboxEvents extends Command
{
    public function __construct(private readonly EventPublisherInterface $publisher)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $events = Outbox::query()
            ->whereNull('processed_at')
            ->oldest('occurred_on')
            ->lockForUpdate()
            ->get();

        foreach ($events as $event) {
            try {
                $this->publisher->publish($event->event_type, $event->payload);
                $event->update(['processed_at' => now()]);
            } catch (Throwable $e) {
                $this->error('Failed to publish event ['.$event->id.']: '.$e->getMessage());

                return self::FAILURE;
            }
        }

        $this->info('Outbox events published: '.$events->count());

        return self::SUCCESS;
    }
}
