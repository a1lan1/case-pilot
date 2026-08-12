<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ApproveCase;

use Spatie\LaravelData\Data;

class ApproveCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
