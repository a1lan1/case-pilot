<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\UpdateCase;

final readonly class UpdateCaseCommand
{
    public function __construct(
        public UpdateCaseDTO $dto
    ) {}
}
