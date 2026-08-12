<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\DeleteCase;

final readonly class DeleteCaseCommand
{
    public function __construct(
        public DeleteCaseDTO $dto
    ) {}
}
