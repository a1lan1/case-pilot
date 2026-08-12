<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property int $id
 * @property string $event_type
 * @property array<array-key, mixed> $payload
 * @property CarbonImmutable $occurred_on
 * @property CarbonImmutable|null $processed_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static Builder<static>|Outbox newModelQuery()
 * @method static Builder<static>|Outbox newQuery()
 * @method static Builder<static>|Outbox query()
 * @method static Builder<static>|Outbox whereCreatedAt($value)
 * @method static Builder<static>|Outbox whereEventType($value)
 * @method static Builder<static>|Outbox whereId($value)
 * @method static Builder<static>|Outbox whereOccurredOn($value)
 * @method static Builder<static>|Outbox wherePayload($value)
 * @method static Builder<static>|Outbox whereProcessedAt($value)
 * @method static Builder<static>|Outbox whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[Table(name: 'outbox')]
class Outbox extends Model
{
    protected $guarded = [];

    #[Override]
    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'occurred_on' => 'datetime',
            'processed_at' => 'datetime',
        ];
    }
}
