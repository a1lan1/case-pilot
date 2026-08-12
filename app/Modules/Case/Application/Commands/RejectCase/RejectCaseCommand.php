<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\RejectCase;

final readonly class RejectCaseCommand
{
    public function __construct(
        public RejectCaseDTO $dto
    ) {}
}
