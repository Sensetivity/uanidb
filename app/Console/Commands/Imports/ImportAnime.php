<?php

namespace App\Console\Commands\Imports;

use App\Jobs\DownloadAnimeImagesJob;
use App\Jobs\ImportAnimeJob;
use App\Jobs\TranslateAnimeJob;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Console\Command;

class ImportAnime extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a single anime by MAL ID';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:anime
        {malId : MyAnimeList ID}
        {--force : Force update even if anime exists}
        {--queue : Dispatch import as a queued job}
        {--with-images : Download images after import}
        {--translate : Translate to Ukrainian after import}';

    /**
     * Execute the console command.
     */
    public function handle(AnimeImportService $importService): int
    {
        $malId = (int) $this->argument('malId');
        $force = $this->option('force');
        $withImages = $this->option('with-images');
        $translate = $this->option('translate');

        if ($this->option('queue')) {
            ImportAnimeJob::dispatch($malId, $force, $withImages, $translate);
            $this->info("Dispatched import job for MAL ID: {$malId}");

            return self::SUCCESS;
        }

        $this->info("Importing anime with MAL ID: {$malId}...");

        try {
            $anime = $importService->importAnimeByMalId($malId, $force);

            if ($anime) {
                $this->info("Successfully imported: {$anime->title} (ID: {$anime->id})");

                if ($withImages) {
                    DownloadAnimeImagesJob::dispatch($anime->id);
                    $this->info('Dispatched image download job.');
                }

                if ($translate) {
                    TranslateAnimeJob::dispatch($anime->id);
                    $this->info('Dispatched translation job.');
                }
            } else {
                $this->warn("Anime with MAL ID {$malId} not found.");
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
