<?php

namespace App\Console\Commands\Imports;

use App\Jobs\ImportAnimeJob;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Console\Command;

class ImportAnimeBatch extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a batch of anime by MAL ID range';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:anime-batch
        {--from=1 : Starting MAL ID}
        {--to=100 : Ending MAL ID}
        {--force : Force update even if anime exists}
        {--queue : Dispatch imports as queued jobs}';

    /**
     * Execute the console command.
     */
    public function handle(AnimeImportService $importService): int
    {
        $from = (int) $this->option('from');
        $to = (int) $this->option('to');
        $force = $this->option('force');

        $this->info("Importing anime from MAL ID {$from} to {$to}...");

        if ($this->option('queue')) {
            for ($malId = $from; $malId <= $to; $malId++) {
                ImportAnimeJob::dispatch($malId, $force);
            }

            $this->info('Dispatched ' . ($to - $from + 1) . ' import jobs.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($to - $from + 1);
        $bar->start();

        $imported = 0;
        $errors = 0;

        for ($malId = $from; $malId <= $to; $malId++) {
            try {
                $anime = $importService->importAnimeByMalId($malId, $force);
                if ($anime) {
                    $imported++;
                }
            } catch (\Exception $e) {
                $errors++;
                $this->newLine();
                $this->warn("Failed to import MAL ID {$malId}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Import completed: {$imported} anime imported successfully.");

        if ($errors > 0) {
            $this->warn("{$errors} anime had errors during import.");
        }

        return self::SUCCESS;
    }
}
