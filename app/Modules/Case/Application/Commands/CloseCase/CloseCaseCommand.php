<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CloseCase;

final readonly class CloseCaseCommand
{
    public function __construct(
        public CloseCaseDTO $dto
    ) {}
}
