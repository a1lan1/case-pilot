<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CompleteCase;

use Spatie\LaravelData\Data;

class CompleteCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
