<?php

declare(strict_types=1);

namespace App\Modules\Case\Domain\Entities;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use App\Modules\Case\Domain\States\Draft;
use App\Modules\Case\Domain\ValueObjects\CaseNumber;
use App\Shared\Domain\Traits\HasDomainEvents;
use App\Shared\Domain\ValueObjects\UuidValueObject;

final class CaseEntity
{
    use HasDomainEvents;

    public function __construct(
        public ?int $id,
        public CaseNumber $number,
        public string $title,
        public ?string $description,
        public string $status,
        public CasePriority $priority,
        public CaseType $type,
        public ?int $customerId,
        public ?UuidValueObject $assigneeId,
        public int $version,
    ) {}

    public static function create(
        string $title,
        ?string $description,
        CasePriority $priority,
        CaseType $type,
        ?int $customerId,
    ): self {
        return new self(
            id: null,
            number: CaseNumber::generate(),
            title: $title,
            description: $description,
            status: Draft::getMorphClass(),
            priority: $priority,
            type: $type,
            customerId: $customerId,
            assigneeId: null,
            version: 1,
        );
    }
}
