<?php

namespace App\Console\Commands\Imports;

use App\Jobs\ImportEpisodesJob;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Console\Command;

class ImportEpisodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:episodes
        {malId : MAL ID of the anime}
        {--queue : Dispatch as queued job}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or reimport episodes for an existing anime';

    /**
     * Execute the console command.
     */
    public function handle(AnimeImportService $importService): int
    {
        $malId = (int) $this->argument('malId');

        $anime = Anime::query()->where('mal_id', $malId)->first();

        if (! $anime) {
            $this->error("Anime with MAL ID {$malId} not found in database.");

            return self::FAILURE;
        }

        if ($this->option('queue')) {
            ImportEpisodesJob::dispatch($anime->id);
            $this->info("Dispatched episode import job for: {$anime->title}");

            return self::SUCCESS;
        }

        $this->info("Importing episodes for: {$anime->title}...");

        try {
            $importService->importEpisodes($anime);
            $this->info("Successfully imported episodes for: {$anime->title}");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
