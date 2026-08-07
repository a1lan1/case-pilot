<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\States;

class Rejected extends CaseState
{
    public static string $name = 'rejected';
}
