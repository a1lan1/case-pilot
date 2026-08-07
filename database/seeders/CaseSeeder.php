<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Case\Domain\Enums\CasePriority;
use App\Modules\Case\Domain\Enums\CaseType;
use App\Modules\Case\Infrastructure\Persistence\Models\CaseModel;
use Illuminate\Database\Seeder;

class CaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create draft cases
        CaseModel::factory(5)->create([
            'title' => 'Draft Support Request',
            'description' => 'This is a draft support request that needs to be completed before submission.',
            'type' => CaseType::SUPPORT,
            'priority' => CasePriority::NORMAL,
        ]);

        // Create submitted cases
        CaseModel::factory(5)->submitted()->create([
            'title' => 'Submitted Installation Request',
            'description' => 'Installation request submitted for review.',
            'type' => CaseType::INSTALLATION,
            'priority' => CasePriority::HIGH,
        ]);

        // Create approved cases
        CaseModel::factory(5)->approved()->create([
            'title' => 'Approved Maintenance Case',
            'description' => 'Maintenance case approved and ready for assignment.',
            'type' => CaseType::MAINTENANCE,
            'priority' => CasePriority::NORMAL,
        ]);

        // Create assigned cases
        CaseModel::factory(5)->assigned()->create([
            'title' => 'Assigned Consultation Case',
            'description' => 'Consultation case assigned to a team member.',
            'type' => CaseType::CONSULTATION,
            'priority' => CasePriority::HIGH,
        ]);

        // Create in-progress cases
        CaseModel::factory(5)->inProgress()->create([
            'title' => 'In-Progress Support Case',
            'description' => 'Support case currently being worked on.',
            'type' => CaseType::SUPPORT,
            'priority' => CasePriority::CRITICAL,
        ]);

        // Create completed cases
        CaseModel::factory(5)->completed()->create([
            'title' => 'Completed Installation Case',
            'description' => 'Installation case successfully completed.',
            'type' => CaseType::INSTALLATION,
            'priority' => CasePriority::NORMAL,
        ]);

        // Create closed cases
        CaseModel::factory(5)->closed()->create([
            'title' => 'Closed Maintenance Case',
            'description' => 'Maintenance case closed after successful completion.',
            'type' => CaseType::MAINTENANCE,
            'priority' => CasePriority::LOW,
        ]);

        // Create cancelled cases
        CaseModel::factory(3)->cancelled()->create([
            'title' => 'Cancelled Support Request',
            'description' => 'Support request cancelled by customer.',
            'type' => CaseType::SUPPORT,
            'priority' => CasePriority::LOW,
        ]);

        // Create mixed cases with different priorities and types
        CaseModel::factory(10)->create();

        // Create cases with customers
        CaseModel::factory(5)->withCustomer()->create([
            'title' => 'Customer Support Request',
            'description' => 'Support request from a registered customer.',
            'type' => CaseType::SUPPORT,
        ]);

        // Create cases with assignees
        CaseModel::factory(5)->withAssignee()->create([
            'title' => 'Assigned Support Case',
            'description' => 'Support case assigned to a specific team member.',
            'type' => CaseType::SUPPORT,
        ]);
    }
}
