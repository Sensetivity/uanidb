<?php

namespace App\Console\Commands\Imports;

use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Console\Command;

class ImportTopAnime extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import top anime from MAL';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:top
        {--type=tv : Type of ranking (all, airing, upcoming, tv, movie, ova, special)}
        {--pages=1 : Number of pages to import}
        {--force : Force update even if anime exists}';

    /**
     * Execute the console command.
     */
    public function handle(AnimeImportService $importService): int
    {
        $type = (string) $this->option('type');
        $pages = (int) $this->option('pages');
        $force = (bool) $this->option('force');

        $this->info("Importing top {$type} anime ({$pages} page(s))...");

        try {
            $results = $importService->importTopAnime($type, $pages, $force);

            $this->info('Successfully imported ' . count($results) . ' anime.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
