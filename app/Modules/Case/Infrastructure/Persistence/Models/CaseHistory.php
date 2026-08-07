<?php

declare(strict_types=1);

namespace App\Modules\Case\Infrastructure\Persistence\Models;

use Carbon\CarbonImmutable;
use Database\Factories\CaseHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property int $id
 * @property int $case_id
 * @property string|null $from_status
 * @property string $to_status
 * @property int|null $user_id
 * @property string|null $comment
 * @property array<array-key, mixed>|null $context
 * @property CarbonImmutable $created_at
 *
 * @method static CaseHistoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|CaseHistory newModelQuery()
 * @method static Builder<static>|CaseHistory newQuery()
 * @method static Builder<static>|CaseHistory query()
 * @method static Builder<static>|CaseHistory whereCaseId($value)
 * @method static Builder<static>|CaseHistory whereComment($value)
 * @method static Builder<static>|CaseHistory whereContext($value)
 * @method static Builder<static>|CaseHistory whereCreatedAt($value)
 * @method static Builder<static>|CaseHistory whereFromStatus($value)
 * @method static Builder<static>|CaseHistory whereId($value)
 * @method static Builder<static>|CaseHistory whereToStatus($value)
 * @method static Builder<static>|CaseHistory whereUserId($value)
 *
 * @mixin \Eloquent
 */
#[Table(name: 'case_history')]
#[WithoutTimestamps]
#[UseFactory(CaseHistoryFactory::class)]
class CaseHistory extends Model
{
    use HasFactory;

    #[Override]
    protected function casts(): array
    {
        return [
            'context' => 'array',
            'created_at' => 'datetime',
        ];
    }
}
