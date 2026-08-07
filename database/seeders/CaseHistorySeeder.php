<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Case\Infrastructure\Persistence\Models\CaseHistory;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;
use Illuminate\Database\Seeder;

class CaseHistorySeeder extends Seeder
{
    public function run(): void
    {
        $cases = CaseModel::all();

        foreach ($cases as $case) {
            // Create initial history entry for the case
            CaseHistory::factory()->forCase($case->id)->create([
                'from_status' => null,
                'to_status' => 'draft',
                'comment' => 'Case created',
                'context' => ['created_by' => 'system'],
                'created_at' => $case->created_at,
            ]);

            // Add history entries based on case status
            if ($case->submitted_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'draft',
                    'to_status' => 'submitted',
                    'comment' => 'Case submitted for review',
                    'context' => ['submitted_by' => 'customer'],
                    'created_at' => $case->submitted_at,
                ]);
            }

            if ($case->approved_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'submitted',
                    'to_status' => 'approved',
                    'comment' => 'Case approved by admin',
                    'context' => ['approved_by' => 'admin'],
                    'created_at' => $case->approved_at,
                ]);
            }

            if ($case->assigned_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'approved',
                    'to_status' => 'assigned',
                    'comment' => 'Case assigned to team member',
                    'context' => ['assignee_id' => $case->assignee_id],
                    'created_at' => $case->assigned_at,
                ]);
            }

            if ($case->started_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'assigned',
                    'to_status' => 'in_progress',
                    'comment' => 'Work started on the case',
                    'context' => ['started_by' => 'assignee'],
                    'created_at' => $case->started_at,
                ]);
            }

            if ($case->completed_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'in_progress',
                    'to_status' => 'completed',
                    'comment' => 'Case work completed',
                    'context' => ['completed_by' => 'assignee'],
                    'created_at' => $case->completed_at,
                ]);
            }

            if ($case->closed_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'completed',
                    'to_status' => 'closed',
                    'comment' => 'Case closed',
                    'context' => ['closed_by' => 'admin'],
                    'created_at' => $case->closed_at,
                ]);
            }

            if ($case->cancelled_at) {
                CaseHistory::factory()->forCase($case->id)->create([
                    'from_status' => 'submitted',
                    'to_status' => 'cancelled',
                    'comment' => 'Case cancelled by customer',
                    'context' => ['reason' => 'customer_request'],
                    'created_at' => $case->cancelled_at,
                ]);
            }

            // Add some random additional history entries for variety
            if (fake()->boolean(30)) {
                CaseHistory::factory()->forCase($case->id)->withComment()->create([
                    'from_status' => $case->status,
                    'to_status' => $case->status,
                    'comment' => 'Additional note added to the case',
                    'created_at' => fake()->dateTimeBetween($case->created_at, 'now'),
                ]);
            }
        }
    }
}
