<?php

declare(strict_types=1);

namespace App\Collectors;

use App\Models\User;
use Spatie\Prometheus\Collectors\Collector;
use Spatie\Prometheus\Facades\Prometheus;

class ModelCountCollector implements Collector
{
    public function register(): void
    {
        Prometheus::addGauge('user_count')
            ->helpText('The total number of users.')
            ->value(fn () => User::count());
    }
}
