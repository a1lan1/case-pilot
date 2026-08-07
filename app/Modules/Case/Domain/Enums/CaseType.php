<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Enums;

enum CaseType: string
{
    case SUPPORT = 'support';
    case INSTALLATION = 'installation';
    case MAINTENANCE = 'maintenance';
    case CONSULTATION = 'consultation';
    case OTHER = 'other';
}
