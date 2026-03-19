<?php

namespace App\Console\Commands;

use App\Services\Sync\DataSyncScheduler;
use Illuminate\Console\Command;

class SyncAnimeCommand extends Command
{
    protected $description = 'Sync anime data based on priority scores';
    protected $signature = 'anime:sync {--batch=10 : Number of anime to sync per run} {--recalculate : Only recalculate priorities, do not dispatch jobs} {--dry-run : Show what would happen without dispatching}';

    public function handle(DataSyncScheduler $scheduler): int
    {
        $batchSize = (int) $this->option('batch');

        $this->info('Recalculating sync priorities...');
        $count = $scheduler->recalculateAllPriorities();
        $this->info("Recalculated priorities for {$count} anime.");

        if ($this->option('recalculate')) {
            return self::SUCCESS;
        }

        $batch = $scheduler->getNextBatch($batchSize);

        if ($batch->isEmpty()) {
            $this->info('No anime need syncing at this time.');

            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->info("Would sync {$batch->count()} anime:");

            foreach ($batch as $anime) {
                $jobs = $scheduler->determineSyncJobs($anime);
                $jobNames = array_map(fn (string $class): string => class_basename($class), $jobs);
                $this->line("  [{$anime->sync_priority}] {$anime->title} (MAL: {$anime->mal_id}) → " . implode(', ', $jobNames));
            }

            return self::SUCCESS;
        }

        $dispatched = 0;
        foreach ($batch as $anime) {
            $scheduler->dispatchSyncForAnime($anime);
            $dispatched++;
        }

        $this->info("Dispatched sync jobs for {$dispatched} anime.");

        return self::SUCCESS;
    }
}
