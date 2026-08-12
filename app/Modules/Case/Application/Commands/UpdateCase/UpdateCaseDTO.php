<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\UpdateCase;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use Spatie\LaravelData\Data;

class UpdateCaseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $version,
        public string $title,
        public ?string $description,
        public CasePriority $priority,
        public CaseType $type,
        public ?int $customerId,
    ) {}
}
