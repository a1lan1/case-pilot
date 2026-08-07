<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseHistory;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseHistory>
 */
class CaseHistoryFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $caseId = CaseModel::query()->inRandomOrder()->first()->id;
        $userId = User::query()->inRandomOrder()->first()->id;

        return [
            'case_id' => $caseId,
            'from_status' => fake()->randomElement([null, 'draft', 'submitted', 'under_review', 'approved', 'rejected', 'assigned', 'in_progress', 'completed', 'closed', 'cancelled']),
            'to_status' => fake()->randomElement(['draft', 'submitted', 'under_review', 'approved', 'rejected', 'assigned', 'in_progress', 'completed', 'closed', 'cancelled']),
            'user_id' => $userId,
            'comment' => fake()->optional()->sentence(),
            'context' => fake()->optional()->randomElement([
                ['reason' => 'Customer request'],
                ['priority' => 'high'],
                ['assigned_by' => 'admin'],
            ]),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Indicate that the history entry has a comment.
     */
    public function withComment(): static
    {
        return $this->state(fn (array $attributes): array => [
            'comment' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the history entry has context.
     */
    public function withContext(): static
    {
        return $this->state(fn (array $attributes): array => [
            'context' => [
                'reason' => fake()->randomElement(['Customer request', 'System update', 'Manual change']),
                'metadata' => fake()->optional()->randomElement(['urgent', 'high-priority', 'routine']),
            ],
        ]);
    }

    /**
     * Indicate that the history entry is for a specific case.
     */
    public function forCase(int $caseId): static
    {
        return $this->state(fn (array $attributes): array => [
            'case_id' => $caseId,
        ]);
    }
}
