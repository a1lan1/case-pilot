<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CancelCase;

use Spatie\LaravelData\Data;

class CancelCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
