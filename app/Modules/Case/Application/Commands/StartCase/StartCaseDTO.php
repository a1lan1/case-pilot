<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\StartCase;

use Spatie\LaravelData\Data;

class StartCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
