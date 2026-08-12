<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\DeleteCase;

use Spatie\LaravelData\Data;

class DeleteCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
    ) {}
}
