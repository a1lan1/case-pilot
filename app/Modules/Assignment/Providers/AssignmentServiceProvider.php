<?php

declare(strict_types=1);

namespace App\Modules\Assignment\Providers;

use App\Modules\Assignment\Domain\Repositories\AssigneeRepositoryInterface;
use App\Modules\Assignment\Infrastructure\Repositories\InMemoryAssigneeRepository;
use Illuminate\Support\ServiceProvider;
use Override;

class AssignmentServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->bind(
            AssigneeRepositoryInterface::class,
            InMemoryAssigneeRepository::class
        );
    }
}
