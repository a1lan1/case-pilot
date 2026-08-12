<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\StartCase;

final readonly class StartCaseCommand
{
    public function __construct(
        public StartCaseDTO $dto
    ) {}
}
