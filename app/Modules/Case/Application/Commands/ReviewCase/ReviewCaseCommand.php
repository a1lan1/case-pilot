<?php

declare(strict_types=1);

namespace App\Modules\Case\Application\Commands\ReviewCase;

final readonly class ReviewCaseCommand
{
    public function __construct(
        public ReviewCaseDTO $dto
    ) {}
}
