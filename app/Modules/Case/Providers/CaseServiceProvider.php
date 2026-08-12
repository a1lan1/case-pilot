<?php

declare(strict_types=1);

namespace App\Modules\Case\Providers;

use App\Modules\Case\Domain\Repositories\CaseRepositoryInterface;
use App\Modules\Case\Infrastructure\Persistence\Repositories\EloquentCaseRepository;
use Illuminate\Support\ServiceProvider;
use Override;

class CaseServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->bind(
            CaseRepositoryInterface::class,
            EloquentCaseRepository::class
        );
    }
}
