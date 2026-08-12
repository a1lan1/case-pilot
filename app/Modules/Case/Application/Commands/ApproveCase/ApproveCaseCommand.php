<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ApproveCase;

final readonly class ApproveCaseCommand
{
    public function __construct(
        public ApproveCaseDTO $dto
    ) {}
}
