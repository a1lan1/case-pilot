<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

#[Description('Re-imports all searchable models')]
#[Signature('scout:reimport-all')]
class ReimportScoutModelsCommand extends Command
{
    /**
     * @var array<class-string>
     */
    protected array $searchableModels = [
        //
    ];

    public function handle(): int
    {
        $this->info('Starting re-import of all searchable models...');

        foreach ($this->searchableModels as $model) {
            $this->line(sprintf('Importing <comment>%s</comment>...', $model));

            Artisan::call('scout:import', ['model' => $model], $this->getOutput());

            $this->info(sprintf('Finished importing <comment>%s</comment>.', $model));
        }

        $this->info('All searchable models have been re-imported successfully!');

        return self::SUCCESS;
    }
}
