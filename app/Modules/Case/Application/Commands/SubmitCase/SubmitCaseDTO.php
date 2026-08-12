<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\SubmitCase;

use Spatie\LaravelData\Data;

class SubmitCaseDTO extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $version,
    ) {}
}
