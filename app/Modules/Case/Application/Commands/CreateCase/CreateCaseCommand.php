<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\CreateCase;

final readonly class CreateCaseCommand
{
    public function __construct(
        public CreateCaseDTO $dto
    ) {}
}
