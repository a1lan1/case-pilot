<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ReviewCase;

use Spatie\LaravelData\Data;

class ReviewCaseDTO extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $version,
    ) {}
}
