<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CloseCase;

use Spatie\LaravelData\Data;

class CloseCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
