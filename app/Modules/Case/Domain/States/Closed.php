<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\States;

class Closed extends CaseState
{
    public static string $name = 'closed';
}
