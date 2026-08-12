<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CompleteCase;

final readonly class CompleteCaseCommand
{
    public function __construct(
        public CompleteCaseDTO $dto
    ) {}
}
