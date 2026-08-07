<?php

declare(strict_types=1);

namespace App\Modules\Case\Infrastructure\Persistence\Models;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use App\Modules\Case\Domain\States\CaseState;
use Carbon\CarbonImmutable;
use Database\Factories\CaseModelFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;
use Spatie\ModelStates\HasStates;

/**
 * @property int $id
 * @property string $number
 * @property string $title
 * @property string|null $description
 * @property CaseState $status
 * @property CasePriority $priority
 * @property CaseType $type
 * @property int|null $customer_id
 * @property string|null $assignee_id
 * @property int $version
 * @property CarbonImmutable|null $submitted_at
 * @property CarbonImmutable|null $approved_at
 * @property CarbonImmutable|null $assigned_at
 * @property CarbonImmutable|null $started_at
 * @property CarbonImmutable|null $completed_at
 * @property CarbonImmutable|null $closed_at
 * @property CarbonImmutable|null $cancelled_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @method static CaseModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|CaseModel newModelQuery()
 * @method static Builder<static>|CaseModel newQuery()
 * @method static Builder<static>|CaseModel orWhereNotState(string $column, $states)
 * @method static Builder<static>|CaseModel orWhereState(string $column, $states)
 * @method static Builder<static>|CaseModel query()
 * @method static Builder<static>|CaseModel whereApprovedAt($value)
 * @method static Builder<static>|CaseModel whereAssignedAt($value)
 * @method static Builder<static>|CaseModel whereAssigneeId($value)
 * @method static Builder<static>|CaseModel whereCancelledAt($value)
 * @method static Builder<static>|CaseModel whereClosedAt($value)
 * @method static Builder<static>|CaseModel whereCompletedAt($value)
 * @method static Builder<static>|CaseModel whereCreatedAt($value)
 * @method static Builder<static>|CaseModel whereCustomerId($value)
 * @method static Builder<static>|CaseModel whereDescription($value)
 * @method static Builder<static>|CaseModel whereId($value)
 * @method static Builder<static>|CaseModel whereNotState(string $column, $states)
 * @method static Builder<static>|CaseModel whereNumber($value)
 * @method static Builder<static>|CaseModel wherePriority($value)
 * @method static Builder<static>|CaseModel whereStartedAt($value)
 * @method static Builder<static>|CaseModel whereState(string $column, $states)
 * @method static Builder<static>|CaseModel whereStatus($value)
 * @method static Builder<static>|CaseModel whereSubmittedAt($value)
 * @method static Builder<static>|CaseModel whereTitle($value)
 * @method static Builder<static>|CaseModel whereType($value)
 * @method static Builder<static>|CaseModel whereUpdatedAt($value)
 * @method static Builder<static>|CaseModel whereVersion($value)
 *
 * @mixin \Eloquent
 */
#[Table(name: 'cases')]
#[UseFactory(CaseModelFactory::class)]
class CaseModel extends Model
{
    use HasFactory;
    use HasStates;

    #[Override]
    protected function casts(): array
    {
        return [
            'status' => CaseState::class,
            'priority' => CasePriority::class,
            'type' => CaseType::class,
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'closed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }
}
