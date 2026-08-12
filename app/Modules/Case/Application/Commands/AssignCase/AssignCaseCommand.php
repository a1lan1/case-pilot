<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\AssignCase;

final readonly class AssignCaseCommand
{
    public function __construct(
        public AssignCaseDTO $dto
    ) {}
}
