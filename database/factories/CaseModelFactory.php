<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use App\Modules\Case\Domain\States\Approved;
use App\Modules\Case\Domain\States\Assigned;
use App\Modules\Case\Domain\States\Cancelled;
use App\Modules\Case\Domain\States\Closed;
use App\Modules\Case\Domain\States\Completed;
use App\Modules\Case\Domain\States\Draft;
use App\Modules\Case\Domain\States\InProgress;
use App\Modules\Case\Domain\States\Submitted;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseModel>
 */
class CaseModelFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 'CASE-'.fake()->unique()->numberBetween(10000, 99999),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => Draft::class,
            'priority' => fake()->randomElement(CasePriority::cases()),
            'type' => fake()->randomElement(CaseType::cases()),
            'customer_id' => null,
            'assignee_id' => null,
            'version' => 1,
            'submitted_at' => null,
            'approved_at' => null,
            'assigned_at' => null,
            'started_at' => null,
            'completed_at' => null,
            'closed_at' => null,
            'cancelled_at' => null,
        ];
    }

    /**
     * Indicate that the case has a customer.
     */
    public function withCustomer(?int $customerId = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'customer_id' => $customerId ?? fake()->numberBetween(1, 100),
        ]);
    }

    /**
     * Indicate that the case has an assignee.
     */
    public function withAssignee(?string $assigneeId = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'assignee_id' => $assigneeId ?? fake()->uuid(),
        ]);
    }

    /**
     * Indicate that the case is submitted.
     */
    public function submitted(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Submitted::class,
            'submitted_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the case is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Approved::class,
            'submitted_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'approved_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ]);
    }

    /**
     * Indicate that the case is assigned.
     */
    public function assigned(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Assigned::class,
            'submitted_at' => fake()->dateTimeBetween('-3 months', '-2 months'),
            'approved_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'assigned_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'assignee_id' => fake()->uuid(),
        ]);
    }

    /**
     * Indicate that the case is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => InProgress::class,
            'submitted_at' => fake()->dateTimeBetween('-4 months', '-3 months'),
            'approved_at' => fake()->dateTimeBetween('-3 months', '-2 months'),
            'assigned_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'started_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'assignee_id' => fake()->uuid(),
        ]);
    }

    /**
     * Indicate that the case is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Completed::class,
            'submitted_at' => fake()->dateTimeBetween('-5 months', '-4 months'),
            'approved_at' => fake()->dateTimeBetween('-4 months', '-3 months'),
            'assigned_at' => fake()->dateTimeBetween('-3 months', '-2 months'),
            'started_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'completed_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'assignee_id' => fake()->uuid(),
        ]);
    }

    /**
     * Indicate that the case is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Closed::class,
            'submitted_at' => fake()->dateTimeBetween('-6 months', '-5 months'),
            'approved_at' => fake()->dateTimeBetween('-5 months', '-4 months'),
            'assigned_at' => fake()->dateTimeBetween('-4 months', '-3 months'),
            'started_at' => fake()->dateTimeBetween('-3 months', '-2 months'),
            'completed_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
            'closed_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'assignee_id' => fake()->uuid(),
        ]);
    }

    /**
     * Indicate that the case is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => Cancelled::class,
            'submitted_at' => fake()->dateTimeBetween('-3 months', '-2 months'),
            'cancelled_at' => fake()->dateTimeBetween('-2 months', '-1 month'),
        ]);
    }
}
