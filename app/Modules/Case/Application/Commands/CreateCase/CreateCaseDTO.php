<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CreateCase;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use Spatie\LaravelData\Data;

class CreateCaseDTO extends Data
{
    public function __construct(
        public string $title,
        public ?string $description,
        public CasePriority $priority,
        public CaseType $type,
        public ?int $customerId,
    ) {}
}
