<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Enums;

enum CasePriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case CRITICAL = 'critical';
}
