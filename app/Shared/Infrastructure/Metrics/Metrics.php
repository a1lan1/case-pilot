<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Metrics;

use Prometheus\CollectorRegistry;
use Prometheus\Counter;

final readonly class Metrics
{
    public function __construct(
        private CollectorRegistry $registry
    ) {}

    public function counter(string $name, string $help, array $labelNames = []): Counter
    {
        return $this->registry->getOrRegisterCounter(
            namespace: (string) config('prometheus.default_namespace'),
            name: $name,
            help: $help,
            labels: $labelNames,
        );
    }
}
