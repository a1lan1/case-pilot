<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CancelCase;

final readonly class CancelCaseCommand
{
    public function __construct(
        public CancelCaseDTO $dto
    ) {}
}
