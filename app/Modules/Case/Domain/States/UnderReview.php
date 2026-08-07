<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\States;

class UnderReview extends CaseState
{
    public static string $name = 'under_review';
}
