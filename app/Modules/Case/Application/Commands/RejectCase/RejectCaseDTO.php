<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\RejectCase;

use Spatie\LaravelData\Data;

class RejectCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
