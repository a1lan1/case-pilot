<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CaseUpdatedForBroadcast implements ShouldBroadcast
{
    use InteractsWithSockets;

    public function __construct(
        public readonly int $caseId,
        public readonly array $caseData,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('cases'),
            new Channel('case.'.$this->caseId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'case.updated';
    }
}
