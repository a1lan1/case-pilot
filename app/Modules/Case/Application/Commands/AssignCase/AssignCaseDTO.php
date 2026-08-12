<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\AssignCase;

use Spatie\LaravelData\Data;

class AssignCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public string $assigneeId,
        public int $version,
    ) {}
}
