<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\States;

class InProgress extends CaseState
{
    public static string $name = 'in_progress';
}
