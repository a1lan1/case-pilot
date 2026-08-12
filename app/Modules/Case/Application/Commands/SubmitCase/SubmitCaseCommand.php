<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\SubmitCase;

final readonly class SubmitCaseCommand
{
    public function __construct(
        public SubmitCaseDTO $dto
    ) {}
}
